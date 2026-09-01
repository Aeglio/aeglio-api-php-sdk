# Aeglio PHP SDK agent guide

## Contract alignment

- For every SDK or application contract change, explicitly assess request DTOs, response entities, public IDs, nullable fields, README examples, OpenAPI/Swagger, and tests in both repositories.
- Update the application implementation, OpenAPI/Swagger schema, SDK types/examples/tests, and public documentation together when affected. Record why any assessed surface needs no change.
- Use stable public IDs and explicit typed payloads. Do not expose application database IDs or silently widen SDK types beyond the documented API contract.

## Verification

- Run the PHP syntax check, `./vendor/bin/phpunit`, and `git diff --check` before handoff.
- Do not publish a package version, commit, or push unless the user asks.
