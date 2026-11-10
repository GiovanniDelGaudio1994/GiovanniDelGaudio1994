# Node.js Task API — technical code sample

A **small, standalone educational REST-like API** built with Node.js standard libraries. It is **not connected to FORMA AI, DriveGlass, or any private project**.

## Requirements

Node.js **18+**, no npm packages required.

## Run

```bash
node server.js
```

Try:

```bash
curl http://127.0.0.1:3000/health
curl http://127.0.0.1:3000/tasks
curl -X POST http://127.0.0.1:3000/tasks -H 'Content-Type: application/json' -d '{"title":"Review tests"}'
```

## Test

```bash
node --test server.test.js
```

**What to review:** HTTP endpoints, input validation, status codes, in-memory state, and integration tests.

**Scope:** demonstrative code only; no authentication, persistence, concurrent access controls, or production deployment.

© 2026 Giovanni Del Gaudio. All rights reserved. Published for technical review; no open-source license granted.
