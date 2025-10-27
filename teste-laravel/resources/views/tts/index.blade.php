<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTS - Conversor de Voz</title>
    
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background-color: #ffffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #090505ff;
        }

        h1 {
            font-size: 1.8em;
            font-weight: bold;
            color: #bb0606ff;
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #070707ff;
        }

        /* Campos e Botões */
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
            font-size: 0.9em;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Azul de destaque */
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 1em;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button:hover {
            background-color: #030303ff;
        }

        /* Mensagens de Feedback */
        .feedback {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 0.9em;
            border-left: 5px solid;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        /* Player de Áudio */
        .audio-box {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
            text-align: center;
        }

        .audio-title {
            font-size: 1.1em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        audio {
            width: 100%;
            margin: 10px 0;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Conversor de Texto para Voz</h1>

        @if(session('message'))
            <div class="feedback success">
                {{ session('message') }}
            </div>
        @endif
        @if(session('error_message'))
            <div class="feedback error">
                {{ session('error_message') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="feedback error">
                Ocorreram erros de validação no formulário.
            </div>
        @endif

        <form method="POST" action="{{ route('tts.generate') }}">
            @csrf
            
            <label for="text">
                Digite o texto que deseja ouvir:
            </label>
            <textarea
                name="text"
                id="text"
                rows="5"
                placeholder="Digite o texto que deseja ouvir."
                required
            >{{ old('text', session('input_text')) }}</textarea>
            
            @error('text')
                <p style="color: #721c24; font-size: 0.8em; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</p>
            @enderror

            <button type="submit">
                <span>🔊 Gerar Áudio</span>
            </button>
        </form>

        @if(session('audio_url'))
            <div class="audio-box">
                <div class="audio-title">Pronto para Ouvir!</div>
                
                <audio controls autoplay>
                    <source src="{{ session('audio_url') }}" type="audio/mp3">
                    Seu navegador não suporta o player de áudio.
                </audio>
            </div>
        @endif
    </div>
</body>
</html>