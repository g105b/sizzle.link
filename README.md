# A burn-after-read secure secret sharing web app.

Sizzzle link lets you share sensitive information securely - once opened, the secret is deleted and can never be retrieved again.

## Why?

- Send an API key or password to a colleague without it lingering in email history
- Share a private note that should only ever be seen once
- Deliver a one-time access token
- Keep secrets out of long-term inboxes, chat logs, or backups

## How?

- Secrets are encrypted using [libsodium]'s `secretbox` (XSalsa20-Poly1305)
- Only the encrypted payload is stored; the key is sent separately and never stored on the server
- When the link is opened, the server returns the decrypted ciphertext once, and immediately deletes it

Simple, fast, and secure.

***

If you found this repository helpful, please consider [sponsoring the developer][sponsor].

[libsodium]: https://libsodium.gitbook.io/doc/
[sponsor]: https://github.com/sponsors/g105b
