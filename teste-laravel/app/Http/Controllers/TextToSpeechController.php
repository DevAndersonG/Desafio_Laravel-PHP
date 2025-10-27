<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TextToSpeechController extends Controller
{
    /**
     * Mostra a página inicial com o formulário.
     */
    public function index()
    {
        return view('tts.index');
    }

    /**
     * Recebe o texto, envia para a API Voice RSS e retorna o áudio.
     */
    public function generate(Request $request)
    {
        // 1. Validação básica
        $request->validate([
            'text' => 'required|string|max:500',
        ]);

        $text = $request->input('text');
        $request->session()->flash('input_text', $text);
        
        $apiUrl = env('TTS_API_URL');
        $apiKey = env('TTS_API_KEY');

        try {
            // 2. CHAMADA PARA A VOICE RSS (usando GET com parâmetros)
            // A Voice RSS exige que a chave e os parâmetros sejam enviados via GET.
            $response = Http::get($apiUrl, [
                'key' => $apiKey,
                'src' => $text, // O texto de origem
                'hl' => 'pt-br', // Idioma (Português Brasil)
                'c' => 'MP3',    // Formato
                'f' => '8khz_16bit_mono', // Qualidade
                'r' => 0, // Velocidade (normal)
            ]);

            // 3. VERIFICAÇÃO DE SUCESSO E PROCESSAMENTO DO ÁUDIO
            if ($response->successful()) {
                $audioData = $response->body();
                
                // Verifica se a resposta contém conteúdo e não é um erro XML
                if (empty($audioData) || str_starts_with(trim($audioData), '<')) {
                    
                    // Falha na conversão, mas a API retornou status 200
                    $errorMessage = "Falha na conversão. A API retornou um erro: " . (trim($audioData) ?: "Corpo vazio.");
                    Log::error("API Voice RSS falhou: " . $audioData);

                } else {
                    // SUCESSO! Converte o MP3 para Base64.
                    $base64Audio = base64_encode($audioData);
                    $audioUrl = 'data:audio/mp3;base64,' . $base64Audio;
                    
                    return redirect()->route('tts.form')
                                    ->with('audio_url', $audioUrl)
                                    ->with('message', '🎉 Áudio gerado com sucesso!');
                }
            } 
            
            // 4. TRATAMENTO DE ERROS DA API (4xx ou 5xx)
            $status = $response->status();
            $errorMessage = "Erro interno da API (Status $status). Verifique a chave e o limite de uso.";

            if ($status === 401 || $status === 403) {
                $errorMessage = 'ERRO DE AUTENTICAÇÃO (401/403): Sua chave de API está inválida ou inativa.';
            }

            Log::error("API Falhou. Status: $status - Detalhes: " . $response->body());
            return back()->with('error_message', $errorMessage);

        } catch (\Exception $e) {
            // 5. TRATAMENTO DE ERRO DE CONEXÃO/REDE
            $apiUrlLog = env('TTS_API_URL', 'URL Indefinida');
            Log::error("Erro de Conexão: " . $e->getMessage() . " - URL tentada: " . $apiUrlLog);
            
            return back()->with('error_message', " Erro de Conexão. Não foi possível acessar a URL {$apiUrlLog}.");
        }
    }
}