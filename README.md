Voici le modèle `README.md` en français pour votre projet d'API de gestion des tâches :

---

# API de Gestion des Tâches

## Vue d'ensemble

Ce projet est une application backend conçue pour gérer une **API de gestion des tâches**. Elle permet aux utilisateurs de créer, mettre à jour et supprimer des tâches, ainsi que créer un compte, s'identifier et se déconnecter. L'API est construite avec **PHP** et interagit avec une base de données **MySQL**.
Dans ce projet le frontend nous est fournis, l'objectif principal est de développer le backend et les fonctionnalités de l'API.

## Fonctionnalités

L'API inclut les fonctionnalités suivantes :

1. **Inscription de l'utilisateur** : Les utilisateurs peuvent créer un compte en fournissant un `username` et un `password`.
2. **Connexion de l'utilisateur** : Les utilisateurs peuvent se connecter avec leur `username` et `password`.
3. **Déconnexion de l'utilisateur** : Les utilisateurs peuvent se déconnecter de leur session.
4. **Gestion des tâches** :
   - **Créer des tâches** : Les utilisateurs peuvent créer de nouvelles tâches avec un titre et une description.
   - **Marquer des tâches comme complètes** : Les utilisateurs peuvent marquer une tâche comme terminée en mettant à jour son statut.
   - **Supprimer des tâches** : Les utilisateurs peuvent supprimer des tâches qu'ils ont créées.
   - **Lister les tâches** : Les utilisateurs peuvent récupérer toutes les tâches associées à leur compte.

## Points de terminaison de l'API

### 1. **Inscription d'un utilisateur**
- **Méthode** : `POST /api/register.php`
- **Corps de la requête** :
  ```json
  {
    "username": "votre_nom_utilisateur",
    "password": "votre_mot_de_passe"
  }
  ```
- **Exemple de réponse** :
  ```json
  {
    "message": "Inscription réussie"
  }
  ```

### 2. **Connexion d'un utilisateur**
- **Méthode** : `POST /api/login.php`
- **Corps de la requête** :
  ```json
  {
    "username": "votre_nom_utilisateur",
    "password": "votre_mot_de_passe"
  }
  ```
- **Exemple de réponse** :
  ```json
  {
    "message": "Connexion réussie"
  }
  ```

### 3. **Déconnexion d'un utilisateur**
- **Méthode** : `POST /api/logout.php`
- **Exemple de réponse** :
  ```json
  {
    "message": "Déconnexion réussie"
  }
  ```

### 4. **Ajouter une tâche**
- **Méthode** : `POST /api/tasks.php`
- **Corps de la requête** :
  ```json
  {
    "title": "Titre de la tâche",
    "description": "Description de la tâche"
  }
  ```
- **Exemple de réponse** :
  ```json
  {
    "message": "Tâche ajoutée avec succès"
  }
  ```

### 5. **Marquer une tâche comme complétée**
- **Méthode** : `POST /api/tasks.php`
- **Corps de la requête** :
  ```json
  {
    "id": 1,
    "completed": 1,
    "action": "complete"
  }
  ```
- **Exemple de réponse** :
  ```json
  {
    "message": "Tâche mise à jour avec succès"
  }
  ```

### 6. **Supprimer une tâche**
- **Méthode** : `DELETE /api/tasks.php`
- **Corps de la requête** :
  ```json
  {
    "id": 1
  }
  ```
- **Exemple de réponse** :
  ```json
  {
    "message": "Tâche supprimée avec succès"
  }
  ```

### 7. **Lister les tâches**
- **Méthode** : `GET /api/tasks.php`
- **Exemple de réponse** :
  ```json
  [
    {
      "id": 1,
      "title": "Ma première tâche",
      "description": "Description de la tâche",
      "completed": 0
    },
    {
      "id": 2,
      "title": "Ma deuxième tâche",
      "description": "Autre description de tâche",
      "completed": 1
    }
  ]
  ```

## Structure de la base de données

Le projet utilise deux tables principales pour gérer les utilisateurs et les tâches :

### Table `users` :
- `id` (Clé primaire, INT)
- `username` (VARCHAR, Unique)
- `password` (VARCHAR)

### Table `tasks` :
- `id` (Clé primaire, INT)
- `user_id` (Clé étrangère, INT)
- `title` (VARCHAR)
- `description` (TEXT)
- `completed` (BOOLEAN, 0 ou 1)
- `created_at` (TIMESTAMP)

## Sécurité

- **Hachage des mots de passe** : Les mots de passe des utilisateurs sont hachés à l'aide de `password_hash()` lors de l'inscription, et vérifiés avec `password_verify()` lors de la connexion.
- **Gestion des sessions** : Des sessions PHP sont utilisées pour gérer l'authentification de l'utilisateur après la connexion.

## Instructions d'installation

1. **Cloner le dépôt** :
   ```bash
   git clone https://github.com/CynthiaStephan/task_administrator_php.git
   ```

2. **Configurer la base de données** :
   - Créez une base de données MySQL.

3. **Mettre à jour la configuration de la base de données** :
   - Modifiez le fichier `config/config.php` pour fournir vos détails de connexion à la base de données.


## Création de la base de données

```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  completed BOOLEAN DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```
