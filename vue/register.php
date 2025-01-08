<body>
    <form action="register.php" method="POST">
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" required>

        <label for="name">Nom</label>
        <input type="text" name="name" id="name" required>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Adresse email :</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Vous êtes un(e)</label>
        <select name="role" id="role" required>
            <option value="freelance">Freelance</option>
            <option value="recruiter">Recruteur(euse)</option>
        </select>

        <button type="submit">S'inscrire</button>

    </form>
</body>