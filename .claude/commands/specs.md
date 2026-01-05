# /specs - Feature Specification Manager

Manage feature specifications stored in `specs/` for EchoForge Website.

## Arguments
- No arguments: List all specs grouped by status
- `show <filename>`: Display a spec's contents
- `work <filename>`: Start working on an approved spec
- `dashboard`: Show Kanban-style board
- `create <filename>`: Create new spec from template

---

## IMPORTANT: Use the specs.py CLI Tool

**All spec operations use the shared `specs.py` CLI tool:**

```bash
# List all specs
python3 ../tools/specs.py list

# Show spec details
python3 ../tools/specs.py show <filename>

# Change spec status
python3 ../tools/specs.py status <filename> <new_status>

# Show Kanban dashboard
python3 ../tools/specs.py dashboard

# Create new spec from template
python3 ../tools/specs.py create <filename>
```

**DO NOT write inline Python code to parse specs.** Always use the tool.

---

## Work Mode: `/specs work [filename]`

1. List approved specs
2. Show the spec details
3. Update status to in_development
4. Create implementation plan
5. Begin implementation

---

## Status Values Reference

| Status | Meaning |
|--------|---------|
| `draft` | Initial creation |
| `approved` | Ready for development |
| `in_development` | Currently being implemented |
| `deployed` | Complete and in production |

---

## Frontmatter Format

```yaml
---
title: Feature Name
version: "1.0"
status: draft
project: EchoForge Website
created: 2025-01-05
updated: 2025-01-05
---
```
