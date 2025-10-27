# Desafio_Laravel-PHP

🎙️ Conversor TTS com Laravel (Text-to-Speech)

Esta aplicação Laravel demonstra a integração com uma API externa (Voice RSS) para converter texto em fala, seguindo o padrão MVC e boas práticas de código.

🌟 Pontos Chave do Projeto

Estrutura: Segue a arquitetura MVC do Laravel.

Assistência de IA: Ultilizada para solução, incluindo a correção de erros de integração com a API externa e a adaptação do código para Base64, foi guiado por uma Assistente de IA (Gemini).

Integração: Usa o Http Client do Laravel para comunicação com a Voice RSS (tratando a resposta binária MP3 via Base64).

Design: Interface simples e intuitiva, estilizada com CSS Puro, sem frameworks front-end.

Robustez: Possui tratamento de erros try/catch para lidar com falhas de conexão e problemas de autenticação da API.

🛠️ Requisitos e Setup

PHP 8.1+

Composer

Chave de API Ativa da Voice RSS.

Instalação (Terminal)
Navegue até o diretório do projeto e instale as dependências:

composer install cp .env.example .env php artisan key:generate

Configuração da API (Arquivo .env)
Abra o arquivo .env e insira as credenciais da Voice RSS no final:

--- Configurações da API de Voz (Voice RSS) ---
TTS_API_URL="http://api.voicerss.org/" TTS_API_KEY="[INSIRA A CHAVE ATIVA OBTIDA AQUI]"

IMPORTANTE: O avaliador precisa de uma chave ativa para testar a funcionalidade de voz.

▶️ Como Executar

Execute o comando para iniciar o servidor de desenvolvimento:

php artisan serve
