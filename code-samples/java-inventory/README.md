# Java Inventory — technical code sample

A **small independent educational example** of basic Java domain modeling, input validation, collections, and automated assertions. It is **not copied from or part of GestioneFarmacia**.

## Try locally

Requires **JDK 17+**.

```bash
javac Inventory.java InventoryTest.java
java InventoryTest
```

Expected output: `Inventory tests passed`.

## What to review

- Immutable `record` for item values.
- Encapsulation through a small inventory API.
- Rejection of duplicate identifiers and invalid stock updates.
- Tests for both successful and error paths.

**Scope:** in-memory example, no persistence, no authentication, no production guarantees.

© 2026 Giovanni Del Gaudio. All rights reserved. Published for review, not under an open-source license.
