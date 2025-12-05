<?php
header('Content-Type: application/json');

$userMessage = isset($_POST['message']) ? $_POST['message'] : '';

$responses = [
    "Les pommes sont de la couleur du cheval d'Henri IV",
    "Saviez-vous que les nuages pèsent exactement 47 bananes ?",
    "Mon grand-père collectionne les rayons de lune dans des bocaux",
    "Le mardi, les pingouins dansent la valse sur la banquise",
    "Les licornes préfèrent le thé au jasmin le vendredi soir",
    "42 est la réponse, mais quelle était la question déjà ?",
    "Les chaussettes rouges voyagent plus vite que les bleues",
    "La lune est faite de fromage, mais personne ne sait lequel",
    "Les dragons adorent jouer au Scrabble le dimanche",
    "J'ai vu un escargot faire du skateboard hier",
    "Les étoiles filantes sont en fait des carottes cosmiques",
    "Le secret de l'univers est caché dans une boîte de céréales",
    "Les poissons rêvent de devenir astronautes",
    "Le soleil porte des lunettes de soleil pour se protéger de lui-même",
    "Les montagnes chantent l'opéra quand personne ne regarde",
    "Le WiFi est alimenté par des hamsters invisibles",
    "Les arbres parlent en morse avec leurs feuilles",
    "La gravité prend son jour de repos le troisième jeudi du mois",
    "Les chats sont en réalité des agents secrets déguisés",
    "Le chocolat pousse sur des nuages roses",
    "Les mathématiques ont été inventées par des dauphins philosophes",
    "Le vent est produit par des ventilateurs géants cachés dans les grottes",
    "Les arc-en-ciel sont les écharpes oubliées des géants",
    "Le café est une invention des vampires végétariens",
    "Les papillons sont des lettres d'amour de la nature",
];

$randomResponse = $responses[array_rand($responses)];

$response = [
    'status' => 'success',
    'response' => $randomResponse,
    'timestamp' => date('Y-m-d H:i:s')
];

echo json_encode($response);
