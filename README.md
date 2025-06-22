# 🚲 Stadtradeln Web-App (mit WebUntis-Login)

Diese Web-App ermöglicht es Schüler:innen einer Schule, ihre gefahrenen Kilometer während der Aktion **Stadtradeln** selbstständig online einzutragen. Die Daten werden klassenweise aggregiert und live als Balkendiagramm visualisiert.

## 🔐 Login mit WebUntis

Nur angemeldete Schüler:innen mit gültigem WebUntis-Account erhalten Zugriff auf das Eingabeformular. Die Klasse wird anhand einer Zuordnung automatisch erkannt.

## 📂 Projektstruktur

```
stadtradeln_webapp/
├── auth/
│   ├── webuntis_login.php
│   ├── webuntis_config.php
│   └── klassenzuordnung.php
├── admin_dashboard.php
├── data.php
├── index.php
├── init_db.php
├── landing.html
├── logout.php
├── submit.php
├── README.md
├── LICENSE
└── .gitignore
```

## ✅ Funktionen

- WebUntis-Login über JSON-RPC
- Automatische Klassenzuordnung
- Live-Diagramm mit Chart.js
- Admin-Dashboard (öffentlich sichtbar)
- SQLite-basierte Speicherung

## 📜 Lizenz

MIT License – siehe [LICENSE](LICENSE)
