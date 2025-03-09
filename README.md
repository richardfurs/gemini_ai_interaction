### Setup

```
./vendor/bin/sail up
```
```
./vendor/bin/sail artisan key:generate
```
```
./vendor/bin/sail artisan migrate
```
```
add your gemini api key GEMINI_API_KEY=your_google_gemini_api_key
```

### Example request for Gemini AI API:

```
http://localhost/api/ask
```

``` json
{
    "contents": {
        "parts" : {
            "text": "Hello"
        }
    }
}
```

### Example response from Gemini AI API:

```json
{
  "candidates": [
    {
      "content": {
        "parts": [
          {
            "text": "Hello there! How can I help you today?"
          }
        ],
        "role": "model"
      },
      "finishReason": "STOP",
      "avgLogprobs": -0.097959052432667129
    }
  ],
  "usageMetadata": {
    "promptTokenCount": 1,
    "candidatesTokenCount": 11,
    "totalTokenCount": 12,
    "promptTokensDetails": [
      {
        "modality": "TEXT",
        "tokenCount": 1
      }
    ],
    "candidatesTokensDetails": [
      {
        "modality": "TEXT",
        "tokenCount": 11
      }
    ]
  },
  "modelVersion": "gemini-2.0-flash"
}
```