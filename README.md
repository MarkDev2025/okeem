# Okeem – Application Laravel + Vue.js

Bienvenue dans le projet **Okeem**, une application fullstack avec un backend **Laravel (SQLite)** et un frontend **Vue 3 + Vite**, conçue pour une démonstration technique.

---

## 🚀 Lancement rapide avec Docker (recommandé)

### Prérequis

- [Docker](https://www.docker.com/) installé

### Étapes

```bash
git clone https://github.com/MarkDev2025/okeem.git
cd okeem
docker-compose up --build
```

### Accès

- Backend Laravel (API) : http://localhost:8000
- Frontend Vue 3 : http://localhost:5173

---

## 🛠️ Installation manuelle (sans Docker)

### Prérequis

- PHP ≥ 8.2
- [Composer](https://getcomposer.org/)
- Node.js ≥ 18
- [npm](https://www.npmjs.com/)
- SQLite3

### 🔧 Backend Laravel (`okeem-admin`)

```bash
cd okeem-admin
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

> 💡 S'assurer que `.env` contient :
>
> ```env
> DB_CONNECTION=sqlite
> DB_DATABASE=./database/database.sqlite
> ```

### 🎨 Frontend Vue 3 (`okeem-front`)

```bash
cd okeem-front
npm install
npm run dev
```

### Accès manuel

- Backend : http://127.0.0.1:8000
- Frontend : http://localhost:5173

---

## 🔐 Accès démo

> mot de passe requis pour le frontend et le backend.

---

## 📁 Structure du projet

```
okeem/
├── okeem-admin/     # Projet Laravel
├── okeem-front/     # Projet Vue 3
├── docker-compose.yml
├── Dockerfile.backend
├── Dockerfile.frontend
└── README.md
```

---

## 🧾 À propos

> 💡 Ce projet est une démonstration technique destinée à valider les choix d’architecture et le bon fonctionnement du setup Docker. L’objectif était de livrer une base fonctionnelle, lisible et extensible rapidement.

---

[![Made with Laravel and Vue](https://img.shields.io/badge/Built%20with-Laravel%20%26%20Vue.js-brightgreen)]()

---

## Exemples de requêtes Graphql sur graphiql (à utiliser de préférence par rapport à l'api)

### Mise à jour d'une transmission

```js
mutation {
  updateTransmission(
    id: "1"
    message: "Mise à jour du message"
    jour: "2025-03-25"
    heure_debut: "08:00"
    heure_fin: "12:00"
    etablissement_id: "1"
    okeemien_id: "1"
    enfant_id: "1"
  ) {
    id
    message
    jour
    heure_debut
    heure_fin
    etablissement_id
    okeemien_id
    enfant_id
  }
}
```

### Consulter une transmission

```js
query MyQuery {
  transmission(id: "1") {
    heure_debut
    heure_fin
    message
    jour
  }
}
```

### Consulter le montant d'une facture d'un parent

```js
query MyQuery {
  tuteur(id: "1") {
    nom
    prenom
    factures {
      id
      montant
    }
  }
}
```

---

## 📌 TODO technique (améliorations possibles)

- [x] Corriger la réactivité aux modifications frontend Vue (vue formulaire Okeemien)
- [ ] Corriger la réactivité aux modifications frontend Vue (vue tableau de bord)
- [ ] Corriger la réactivité aux modifications frontend Vue (vue parent)
- [ ] Corriger la réactivité aux modifications frontend Vue (vue enfant)
- [ ] Ajouter des tests unitaires (backend Laravel + frontend Vue)
- [ ] Ajouter des tests fonctionnels (Cypress)
- [ ] Améliorer l'intégration de GraphQL dans le backend
- [ ] Factoriser certaines fonctions côté frontend (réutilisabilité)
- [ ] Ajouter une page 404 personnalisée
