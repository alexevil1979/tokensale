# TokenHub

Commercial AI API platform (Laravel 11) deployed at `https://tokensale.linkus1.online`.

## Stack
- Laravel 11 + PHP 8.4
- MySQL 8 + Redis 7
- Docker Compose
- LiteLLM gateway (optional profile)
- Nginx + Let's Encrypt

## Features
- Auth, cabinet, API keys
- Wallet ledger (integer cents)
- Model catalog and pricing admin
- Usage stats, rate limits
- Payment webhook endpoint
- Health/metrics APIs

## Quick start (VPS)
```bash
cd /opt/tokenhub
/usr/local/bin/docker-compose-v2 up -d
```

Admin: `/admin` after login.
