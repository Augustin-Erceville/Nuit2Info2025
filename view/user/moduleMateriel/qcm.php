<?php
session_start();
// MODULE : Test sportif avancé (20 questions) + vidéos & recommandations
// Pas de base de données : tout en mémoire et affiché uniquement

// --- Définition du questionnaire (20 questions) ---
$questions = [
        ["q"=>"Combien de fois faites-vous du sport par semaine ?",
                "name"=>"q1",
                "options"=>[
                        ["t"=>"0", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"1-2", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"3-4", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                        ["t"=>"5+", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>3,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Durée moyenne d'une séance ?",
                "name"=>"q2",
                "options"=>[
                        ["t"=>"< 20 min", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>1,"frequence"=>0,"experience"=>0]],
                        ["t"=>"20-40 min", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"40-60 min", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>" 60 min", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Intensité habituelle des séances ?",
                "name"=>"q3",
                "options"=>[
                        ["t"=>"Très faible", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>1,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Modérée", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Forte", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Très intense", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Peux-tu courir 30 minutes sans t'arrêter ?",
                "name"=>"q4",
                "options"=>[
                        ["t"=>"Non", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Oui, lentement", "s"=>["endurance"=>1,"force"=>0,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Oui, à rythme modéré", "s"=>["endurance"=>2,"force"=>0,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Oui, à bon rythme", "s"=>["endurance"=>3,"force"=>0,"mobilite"=>1,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Combien de pompes (push-ups) environ ?",
                "name"=>"q5",
                "options"=>[
                        ["t"=>"0-5", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"6-15", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>0,"frequence"=>1,"experience"=>1]],
                        ["t"=>"16-30", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>0,"frequence"=>2,"experience"=>2]],
                        ["t"=>">30", "s"=>["endurance"=>2,"force"=>3,"mobilite"=>0,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Peux-tu faire un squat profond sans douleur ?",
                "name"=>"q6",
                "options"=>[
                        ["t"=>"Non", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Avec difficulté", "s"=>["endurance"=>0,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Oui, correctement", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Oui, très bien", "s"=>["endurance"=>1,"force"=>3,"mobilite"=>3,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Avez-vous des douleurs chroniques / blessures ?",
                "name"=>"q7",
                "options"=>[
                        ["t"=>"Oui, importantes", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Oui, légères", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Rarement", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Jamais", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                ]
        ],
        ["q"=>"Préférence d'entraînement ?",
                "name"=>"q8",
                "options"=>[
                        ["t"=>"Cardio long", "s"=>["endurance"=>3,"force"=>0,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Musculation", "s"=>["endurance"=>0,"force"=>3,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Mobilité / souplesse", "s"=>["endurance"=>1,"force"=>0,"mobilite"=>3,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Mix", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"As-tu déjà suivi un programme structuré ?",
                "name"=>"q9",
                "options"=>[
                        ["t"=>"Jamais", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Quelques semaines", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Plusieurs mois", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Années", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Capacité à maintenir une bonne posture pendant 30s ?",
                "name"=>"q10",
                "options"=>[
                        ["t"=>"Non", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Avec effort", "s"=>["endurance"=>0,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Oui", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Très bonne", "s"=>["endurance"=>2,"force"=>3,"mobilite"=>3,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Combien de marches peux-tu monter sans t'arrêter ?",
                "name"=>"q11",
                "options"=>[
                        ["t"=>"Peu (1-2 étages)", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"2-4 étages", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"5-8 étages", "s"=>["endurance"=>2,"force"=>1,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>">8 étages", "s"=>["endurance"=>3,"force"=>2,"mobilite"=>1,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Peux-tu tenir une planche (plank) correctement ?",
                "name"=>"q12",
                "options"=>[
                        ["t"=>"0-10s", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"10-30s", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>0,"frequence"=>1,"experience"=>1]],
                        ["t"=>"30-60s", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>">60s", "s"=>["endurance"=>2,"force"=>3,"mobilite"=>1,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Sens-tu de la fatigue articulaire après l'effort ?",
                "name"=>"q13",
                "options"=>[
                        ["t"=>"Souvent", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Parfois", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Rarement", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Jamais", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Capacité à récupérer entre 2 séances (fatigue) ?",
                "name"=>"q14",
                "options"=>[
                        ["t"=>"Très lente", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Lente", "s"=>["endurance"=>0,"force"=>1,"mobilite"=>0,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Normale", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Rapide", "s"=>["endurance"=>2,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Aimes-tu les exercices techniques (apprendre une posture) ?",
                "name"=>"q15",
                "options"=>[
                        ["t"=>"Non", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Parfois", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Oui", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Beaucoup", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>3,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Ton objectif principal ?",
                "name"=>"q16",
                "options"=>[
                        ["t"=>"Perte de poids", "s"=>["endurance"=>2,"force"=>1,"mobilite"=>1,"frequence"=>2,"experience"=>1]],
                        ["t"=>"Prise de masse", "s"=>["endurance"=>0,"force"=>3,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Souplesse / bien-être", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>3,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Performance (compétition)", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Fais-tu des étirements réguliers ?",
                "name"=>"q17",
                "options"=>[
                        ["t"=>"Jamais", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Rarement", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>1,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Oui parfois", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>2,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Oui systématiquement", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>3,"frequence"=>2,"experience"=>2]],
                ]
        ],
        ["q"=>"Travail en salle / avec charges ?",
                "name"=>"q18",
                "options"=>[
                        ["t"=>"Jamais", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Peu", "s"=>["endurance"=>0,"force"=>1,"mobilite"=>0,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Régulièrement", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Souvent + programmé", "s"=>["endurance"=>1,"force"=>3,"mobilite"=>1,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"As-tu déjà travaillé la technique (coach / tuto) ?",
                "name"=>"q19",
                "options"=>[
                        ["t"=>"Jamais", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Parfois", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Souvent", "s"=>["endurance"=>1,"force"=>2,"mobilite"=>2,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Toujours", "s"=>["endurance"=>2,"force"=>3,"mobilite"=>3,"frequence"=>3,"experience"=>3]],
                ]
        ],
        ["q"=>"Comment te sens-tu en fin de séance ?",
                "name"=>"q20",
                "options"=>[
                        ["t"=>"Écrasé / très fatigué", "s"=>["endurance"=>0,"force"=>0,"mobilite"=>0,"frequence"=>0,"experience"=>0]],
                        ["t"=>"Fatigué mais bien", "s"=>["endurance"=>1,"force"=>1,"mobilite"=>1,"frequence"=>1,"experience"=>1]],
                        ["t"=>"Énergisé", "s"=>["endurance"=>2,"force"=>2,"mobilite"=>1,"frequence"=>2,"experience"=>2]],
                        ["t"=>"Très bien, performant", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
                ]
        ]
];

$video_by_sport = [
        "Yoga" => "https://www.youtube.com/watch?v=3X0hEHop8ec",
        "Musculation" => "https://www.youtube.com/watch?v=gOViaSi6y38",
        "Fitness" => "https://www.youtube.com/watch?v=AdqrTg_hpEQ",
        "Course" => "https://www.youtube.com/watch?v=5KHtPFCzKb0"
];

$images = [
        "Yoga" => "../../../src/img/Yoga-Pastel-Sun-FB.webp",
        "Musculation" => "../../../src/img/muscu.avif",
        "Fitness" => "../../../src/img/fitness.webp",
        "Course" => "../../../src/img/course.gif"
];

$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");
$domains = ["endurance","force","mobilite","frequence","experience"];
$totals = array_fill_keys($domains, 0);
$max_possible = array_fill_keys($domains, 0);
$answers = [];

if ($submitted) {
    foreach ($questions as $i => $q) {
        $name = $q['name'];
        $valIndex = isset($_POST[$name]) ? (int)$_POST[$name] : 0;
        if ($valIndex < 0 || $valIndex >= count($q['options'])) $valIndex = 0;
        $answers[$name] = $valIndex;

        foreach ($q['options'] as $optIndex => $opt) {
            foreach ($domains as $d) {
                $val = (int)$opt['s'][$d];
                if (!isset($max_per_q[$i][$d]) || $val > $max_per_q[$i][$d]) {
                    $max_per_q[$i][$d] = $val;
                }
            }
        }

        $chosen = $q['options'][$valIndex];
        foreach ($domains as $d) {
            $totals[$d] += (int)$chosen['s'][$d];
        }
    }

    foreach ($questions as $i => $q) {
        foreach ($domains as $d) {
            $max_possible[$d] += $max_per_q[$i][$d];
        }
    }

    $percent = [];
    foreach ($domains as $d) {
        $percent[$d] = $max_possible[$d] > 0 ? round(($totals[$d] / $max_possible[$d]) * 100) : 0;
    }

    $global_score = round(array_sum($percent) / count($percent));
    if ($global_score < 35) $profile = "Débutant";
    elseif ($global_score < 65) $profile = "Intermédiaire";
    else $profile = "Avancé";

    $sport = $_POST['sport'] ?? "Fitness";
    $objectif = htmlspecialchars($_POST['objectif'] ?? "");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Sportif - Matériel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Styles spécifiques au test sportif -->
    <style>
        /* Layout spécifique */
        .module-wrap { max-width: 1000px; margin: 20px auto; padding: 20px; }
        .card { background: #dedddd; border-radius:12px; box-shadow:0 6px 30px rgba(15,20,30,0.06); padding:20px; margin-bottom:18px; }
        .grid { display:flex; gap:18px; flex-wrap:wrap; }
        .col { flex: 1 1 300px; min-width:260px; }
        .form-row { margin-bottom:12px; }
        .question { margin-bottom:10px; padding:12px; border-radius:8px; background:#fbfdff; }
        .options label { display:block; margin:6px 0; cursor:pointer; }
        .btn-sport { display:inline-block; background:#0078f2; color:#fff; padding:10px 16px; border-radius:8px; border:none; cursor:pointer; text-decoration:none; }
        .small { font-size:0.9rem; color:#555; }
        .progress { height:14px; background:#e6eefc; border-radius:12px; overflow:hidden; }
        .progress > span { display:block; height:100%; width:0%; background:linear-gradient(90deg,#3b82f6,#06b6d4); border-radius:12px; transition: width 900ms cubic-bezier(.2,.9,.2,1); }
        @media (max-width:760px){ .grid{flex-direction:column;} }

        .video-wrap { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px; }
        .video-wrap iframe { position:absolute; top:0; left:0; width:100%; height:100%; border:0; }

        .module-header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px; }
        .module-title { font-size:1.4rem; font-weight:600; }
        .kv { font-size:0.95rem; color:#666; }

        .fade-in { animation: fadeIn 0.5s ease-out both; }
        @keyframes fadeIn { from{opacity:0; transform:translateY(8px);} to{opacity:1; transform:none;} }
    </style>
</head>
<body class="bg-dark">

<!-- Navbar identique -->
<!-- Si tu n’as pas nav.php, copie-colle directement ton `<nav>…</nav>` ici -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand d-flex align-items-center" href="../accueil.php">
            <i class="bi bi-moon-stars fs-1 me-2"></i>
            <span class="fs-3 fw-bold text-light">NUIT DE L'INFO</span>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="ms-auto d-none d-lg-flex align-items-center">
                <a href="moduleMaterielMain.php" class="btn btn-outline-light btn-lg me-2 active"
                   data-bs-toggle="tooltip" data-bs-placement="bottom" title="Matériels">
                    <i class="bi bi-pc-display"></i>
                </a>
                <div class="btn-group dropstart">
                    <button class="btn btn-outline-light btn-lg dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-toggle-second="tooltip" data-bs-placement="bottom" title="Compte">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="../connexion.php"><i class="bi bi-person-check-fill me-2"></i>Connexion</a></li>
                        <li><a class="dropdown-item" href="../inscription.php"><i class="bi bi-person-plus-fill me-2"></i>Inscription</a></li>
                    </ul>
                </div>
            </div>
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="moduleMaterielMain.php">
                        <i class="bi bi-pc-display"></i> Matériels
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-light w-100 dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person me-1"></i> Compte
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100">
                        <li><a class="dropdown-item" href="../connexion.php"><i class="bi bi-person-check-fill me-2"></i>Connexion</a></li>
                        <li><a class="dropdown-item" href="../inscription.php"><i class="bi bi-person-plus-fill me-2"></i>Inscription</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr class="text-light">

<div class="container-fluid px-3 px-md-4 py-3">
    <div class="module-wrap">
        <div class="card">
            <div class="module-header">
                <div>
                    <div class="module-title"><i class="bi bi-graph-up me-2"></i> Test Sportif (20 questions)</div>
                    <div class="kv small">Réponds honnêtement : le module te proposera vidéos & programme adapté.</div>
                </div>

            </div>

            <?php if (!$submitted): ?>
                <form method="POST">
                    <div class="grid">
                        <div class="col card fade-in">
                            <h3 class="mb-3"><i class="bi bi-person me-1"></i> Informations de base</h3>
                            <div class="form-row">
                                <label class="small">Sport principal</label>
                                <select name="sport" class="form-select">
                                    <option>Musculation</option>
                                    <option>Fitness</option>
                                    <option>Yoga</option>
                                    <option>Course</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <label class="small">Objectif (ex : prise de force, endurance, souplesse)</label>
                                <input name="objectif" class="form-control" placeholder="Ex : prise de muscle">
                            </div>
                            <div class="form-row mt-3">
                                <button class="btn-sport" type="submit">Lancer le test</button>
                            </div>
                        </div>

                        <div class="col card fade-in">
                            <h3 class="mb-3"><i class="bi bi-question-circle me-1"></i> Questions (20)</h3>
                            <div class="small mb-2">Sélectionne la réponse la plus proche de ta réalité.</div>
                            <hr>
                            <?php foreach ($questions as $i => $q): ?>
                                <div class="question">
                                    <div><strong>Q<?= $i+1 ?>.</strong> <?= htmlspecialchars($q['q']) ?></div>
                                    <div class="options">
                                        <?php foreach ($q['options'] as $optIndex => $opt): ?>
                                            <label>
                                                <input type="radio" name="<?= htmlspecialchars($q['name']) ?>" value="<?= $optIndex ?>"
                                                        <?= $optIndex === 0 ? 'checked' : '' ?>>
                                                &nbsp;<?= htmlspecialchars($opt['t']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>

            <?php else: ?>
                <div class="grid">
                    <div class="col card fade-in">
                        <h3 class="mb-3"><i class="bi bi-bar-chart me-1"></i> Résultats & profil</h3>
                        <p class="small">Profil global : <strong><?= htmlspecialchars($profile) ?></strong> — Score global <?= $global_score ?>%</p>

                        <?php foreach ($percent as $d => $p): ?>
                            <div style="margin-bottom:12px;">
                                <div style="display:flex; justify-content:space-between;">
                                    <div class="small"><?= ucfirst($d) ?></div>
                                    <div class="small"><?= $p ?>%</div>
                                </div>
                                <div class="progress" aria-hidden="true">
                                    <span data-value="<?= $p ?>" style="width:0%"></span>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <hr>
                        <h4 class="small"><i class="bi bi-lightbulb me-1"></i> Interprétation rapide</h4>
                        <ul class="small">
                            <?php
                            foreach ($percent as $d => $p) {
                                if ($p < 35) echo "<li><strong>".ucfirst($d)."</strong> : Faible — travailler progressivement (programmes débutant).</li>";
                                elseif ($p < 65) echo "<li><strong>".ucfirst($d)."</strong> : Moyen — maintenir et progresser avec séances ciblées.</li>";
                                else echo "<li><strong>".ucfirst($d)."</strong> : Bon — tu peux intensifier ou viser la performance.</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="col card fade-in">
                        <h3 class="mb-3"><i class="bi bi-stars me-1"></i> Recommandations personnalisées</h3>
                        <?php
                        asort($percent);
                        $weakest = array_key_first($percent);
                        echo "<p class='small'>Domaine prioritaire : <strong>".ucfirst($weakest)." (".$percent[$weakest]."%)</strong></p>";

                        $advice = [
                                "endurance" => "Travail progressif de cardio (séances 20→40→60min), fractionné léger, augmentation progressive du volume.",
                                "force" => "Priorise mouvements poly-articulaires (squat, développé, tirage), charge progressive, 2-3x/semaine.",
                                "mobilite" => "Intègre 10-15min d'étirements dynamiques + travail de mobilité articulaire avant et après séance.",
                                "frequence" => "Augmente la fréquence progressivement : +1 séance toutes les 2 semaines si récupération ok.",
                                "experience" => "Travaille la technique : tutoriels vidéo, coaching ponctuel, attention à la technique."
                        ];
                        echo "<p>".$advice[$weakest]."</p>";

                        $sport_sel = htmlspecialchars($_POST['sport'] ?? 'Fitness');
                        echo "<hr><h4 class='small'><i class='bi bi-bicycle me-1'></i> Conseils pour le sport : $sport_sel</h4>";

                        $sport_guides = [
                                "Yoga" => "Commence par respirations, salutations au soleil, posture de base. Fractionner entrainement en 15-30min.",
                                "Musculation" => "Commence par 2x semaines full-body, technique -> charge, 8-12 reps pour hypertrophie, 4-6 reps pour force.",
                                "Fitness" => "Circuits 20-35min, mélange cardio & renfo, HIIT modéré si condition OK.",
                                "Course" => "Séances fractionnées + footing long une fois/semaine + renforcement du tronc (plank, fentes)."
                        ];
                        echo "<p>".$sport_guides[$sport_sel]."</p>";

                        echo "<hr><h4 class='small'><i class='bi bi-cart me-1'></i> Produits recommandés</h4>";

                        // Définition des produits (avec URLs propres)
                        $products = [
                                "Yoga" => [
                                        "https://www.decathlon.fr/p/mp/mobiclinic/tapis-de-yoga-fitnessmat-antiderapant-impermeable-6-mm-lavable-flexible/_/R-p-e6472c0c-195e-48ab-b154-1b94b71bbb93?mc=e6472c0c-195e-48ab-b154-1b94b71bbb93_c24&c=rose" => "Tapis de yoga antidérapant (6 mm)",
                                        "https://www.decathlon.fr/p/mp/avento/bloc-de-yoga-lot-de-2-mousse-bleu/_/R-p-5b8b19f6-e527-496a-8cb6-0fc45cd3ad8c?mc=5b8b19f6-e527-496a-8cb6-0fc45cd3ad8c_c5" => "Bloc yoga (mousse)",
                                        "https://www.decathlon.fr/p/sangle-de-yoga-2-5-metres-acajou/_/R-p-183211?mc=8502978&c=gris_blanc" => "Sangle de yoga (2 m)"
                                ],
                                "Musculation" => [
                                        "https://www.decathlon.fr/p/mp/hms/kit-6-en-1-avec-poids-sgn-hms/_/R-p-ee27ce40-0780-4a92-b1f2-144fcc04b106?mc=ee27ce40-0780-4a92-b1f2-144fcc04b106_c1c14&c=noir_rouge" => "Haltères réglables (6 en 1)",
                                        "https://www.decathlon.fr/p/kit-3-training-band-elastiques-15-25-35kg-avec-3-mois-offerts-freeletics/_/R-p-373225?mc=8966621" => "Bandes élastiques (15/25/35 kg)",
                                        "https://www.decathlon.fr/p/ceinture-d-halterophilie-avec-boucle-securisee-violet/_/R-p-360764?mc=8952914&c=bleu_vert" => "Ceinture d'haltérophilie"
                                ],
                                "Fitness" => [
                                        "https://www.decathlon.fr/p/mp/indigo-sports/tapis-de-yoga-et-fitness-nbr-183-61-1-5-cm/_/R-p-d7a636db-8e41-41a3-99f0-c1d985c6ed2d?mc=d7a636db-8e41-41a3-99f0-c1d985c6ed2d_c16" => "Tapis de sol (183×61 cm)",
                                        "https://www.decathlon.fr/p/corde-a-sauter-de-cardio-avec-compteur-800-gris-clair/_/R-p-347905?mc=8901086" => "Corde à sauter + compteur",
                                        "https://www.decathlon.fr/p/mp/indigo-sports/5-bandes-elastiques-en-latex-druna-differents-niveaux-de-resistance-pour-fitness/_/R-p-952590ef-9740-4880-8fff-0324d0f87ce2?mc=952590ef-9740-4880-8fff-0324d0f87ce2_c1c14c22" => "Élastiques résistance (5 niveaux)"
                                ],
                                "Course" => [
                                        "https://www.decathlon.fr/p/chaussures-running-et-trail-femme-jf190-grip-violet/_/R-p-348767?mc=8926956" => "Chaussures running Kalenji EKR 900",
                                        "https://www.decathlon.fr/p/montre-gps-fenix-7-pro-solar-multisports-47mm/_/R-p-378725?mc=8991453" => "Montre cardio GPS Kalenji 500",
                                        "https://www.decathlon.fr/p/mp/sidas/chaussettes-de-ski-et-techniques-pour-enfant-lot-de-2-paires-ski-expert-junior/_/R-p-7b139656-55d9-4953-a24b-505d2cd64c6f?mc=7b139656-55d9-4953-a24b-505d2cd64c6f_c20" => "Chaussettes techniques (lot 3)"
                                ]
                        ];

                        // Affichage dynamique
                        echo '<div class="row g-2 mt-2">';
                        if (isset($products[$sport_sel])) {
                            foreach ($products[$sport_sel] as $url => $label) {
                                $cleanUrl = trim($url);
                                if (filter_var($cleanUrl, FILTER_VALIDATE_URL)) {
                                    echo '
                        <div class="col-12 col-md-6">
                            <a href="' . htmlspecialchars($cleanUrl) . '" target="_blank" class="btn btn-outline-primary w-100 text-start p-2">
                                <i class="bi bi-bag me-2"></i><strong>' . htmlspecialchars($label) . '</strong>
                                <small class="d-block mt-1">→ Voir sur Decathlon</small>
                            </a>
                        </div>';
                                } else {
                                    // fallback si format ancien (juste texte)
                                    echo '<div class="col-12"><p class="small">' . htmlspecialchars($label) . '</p></div>';
                                }
                            }
                        } else {
                            echo '<div class="col-12"><p class="text-muted small">Aucun produit configuré pour ce sport.</p></div>';
                        }
                        echo '</div>';
                        ?>
                    </div>
                </div>

                <div class="card fade-in mt-3">
                    <div class="grid">
                        <div class="col">
                            <h3 class="mb-2"><i class="bi bi-image me-1"></i> Illustration</h3>
                            <?php if (isset($images[$sport_sel])): ?>
                                <img src="<?= htmlspecialchars($images[$sport_sel]) ?>" class="img-fluid rounded">
                            <?php else: ?>
                                <div class="small text-muted">Aucune image configurée pour ce sport.</div>
                            <?php endif; ?>
                        </div>

                        <div class="col">
                            <h3 class="mb-2"><i class="bi bi-play-btn me-1"></i> Vidéo d'exécution — <?= htmlspecialchars($sport_sel) ?></h3>
                            <div class="video-wrap">
                                <?php
                                $vid = trim($video_by_sport[$sport_sel] ?? $video_by_sport['Fitness']);
                                echo '<iframe src="' . htmlspecialchars($vid) . '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen title="Vidéo démo"></iframe>';
                                ?>
                            </div>
                            <p class="small mt-2">Regarde attentivement : posture, respiration, alignement. Reproduis lentement.</p>

                            <hr class="my-2">
                            <h4 class="small"><i class="bi bi-plus-circle me-1"></i> Vidéos complémentaires — domaine faible : <?= ucfirst($weakest) ?></h4>
                            <?php
                            $extra_videos = [
                                    "endurance" => ["https://www.youtube.com/watch?v=_WxjD_nLPsg" => "Endurance : cardio débutant"],
                                    "force" => ["https://www.youtube.com/watch?v=J_Zm4XvE__s" => "Technique : squat parfait"],
                                    "mobilite" => ["https://www.youtube.com/watch?v=P91Vegj3Qxg" => "Mobilité quotidienne"],
                                    "frequence" => ["https://www.youtube.com/watch?v=45l6bl8Uyr4" => "Organiser sa semaine sport"],
                                    "experience" => ["https://www.youtube.com/watch?v=JqSIh5IiVAs" => "Apprendre un mouvement"]
                            ];
                            if (!empty($extra_videos[$weakest])) {
                                foreach ($extra_videos[$weakest] as $url => $label) {
                                    $cleanUrl = trim($url);
                                    echo '<div class="mt-2 small">
                                <strong>' . htmlspecialchars($label) . '</strong>
                                <div class="video-wrap mt-1">
                                    <iframe src="' . htmlspecialchars($cleanUrl) . '" allowfullscreen></iframe>
                                </div>
                              </div>';
                                }
                            } else {
                                echo '<p class="small text-muted">Aucune vidéo complémentaire pour ce domaine.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        document.querySelectorAll('.progress > span').forEach(el => {
                            const v = el.getAttribute('data-value') || '0';
                            setTimeout(() => { el.style.width = v + '%'; }, 100);
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

</body>
</html>