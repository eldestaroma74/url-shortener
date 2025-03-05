# URL Shortener Service

## Installation

1. **Clone the Repository:**
   ```sh
   git clone https://github.com/eldestaroma74/url-shortener.git
   cd url-shortener
   ```

Alternatively, if using Apache, ensure `.htaccess` is enabled.

## Usage

### Encode a URL
**Request:**
```sh
curl -X POST http://localhost/url-shortener/encode \
     -H "Content-Type: application/json" \
     -d '{"url": "https://www.careercanvas.co.uk"}'
```

**Response:**
```json
{"short_url": "http://short.est/a400db"}
```

### Decode a Short URL
**Request:**
```sh
curl -X POST http://localhost//url-shortener/decode \
     -H "Content-Type: application/json" \
     -d '{"short_url": "http://short.est/a400db"}'
```

**Response:**
```json
{"long_url": "https://www.careercanvas.co.uk"}
```


## Notes
- URLs are stored in-memory (session-based) and will reset on server restart.
- Ensure PHP sessions are enabled (`session_start();` is used).
