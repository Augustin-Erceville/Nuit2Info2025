<?php
session_start();
// MODULE : Quiz NIRD avancé avec animations

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
                        ["t"=>"> 60 min", "s"=>["endurance"=>3,"force"=>3,"mobilite"=>2,"frequence"=>3,"experience"=>3]],
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
        "Yoga" => "https://www.youtube.com/embed/3X0hEHop8ec",
        "Musculation" => "https://www.youtube.com/embed/gOViaSi6y38",
        "Fitness" => "https://www.youtube.com/embed/AdqrTg_hpEQ",
        "Course" => "https://www.youtube.com/embed/5KHtPFCzKb0"
];

$images = [
        "Yoga" => "../src/img/Yoga-Pastel-Sun-FB.webp",
        "Musculation" => "../src/img/muscu.avif",
        "Fitness" => "../src/img/fitness.webp",
        "Course" => "../src/img/course.gif"
];

$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");
$domains = ["endurance","force","mobilite","frequence","experience"];
$totals = array_fill_keys($domains, 0);
$max_possible = array_fill_keys($domains, 0);
$answers = [];
$max_per_q = [];

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
    <title>Quiz Sportif NIRD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../src/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1d20 0%, #2d3339 100%);
            color: #f8f9fa;
            min-height: 100vh;
        }

        .quiz-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .quiz-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            animation: slideDown 0.6s ease-out;
        }

        .quiz-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .quiz-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .quiz-card {
            background: #2d3339;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            animation: fadeInUp 0.5s ease-out backwards;
        }

        .quiz-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(13, 110, 253, 0.3);
        }

        .question-card {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #0d6efd;
            transition: all 0.3s ease;
            animation: slideInLeft 0.5s ease-out backwards;
        }

        .question-card:hover {
            transform: translateX(10px);
            border-left-width: 8px;
        }

        .question-number {
            display: inline-block;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: 700;
            margin-right: 1rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .option-label {
            display: block;
            background: #495057;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin: 0.75rem 0;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-label::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(13, 110, 253, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .option-label:hover::before {
            width: 300%;
            height: 300%;
        }

        .option-label:hover {
            background: #5a6268;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }

        .option-label input[type="radio"]:checked + span {
            color: #0d6efd;
            font-weight: 600;
        }

        .option-label input[type="radio"] {
            margin-right: 1rem;
            transform: scale(1.3);
            cursor: pointer;
        }

        .submit-btn {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border: none;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(13, 110, 253, 0.4);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .submit-btn:hover::before {
            width: 300%;
            height: 300%;
        }

        .submit-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.6);
        }

        .progress-bar-custom {
            height: 30px;
            background: #495057;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            margin-bottom: 1rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
            border-radius: 15px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .result-badge {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            border-radius: 50px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 5px 20px rgba(25, 135, 84, 0.4);
            animation: bounceIn 0.8s ease-out;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
            border-left: 4px solid #0d6efd;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateX(10px);
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.2) 0%, rgba(13, 110, 253, 0.1) 100%);
        }

        .btn-outline-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            color: white !important;
        }

        .btn-outline-success:hover .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .btn-outline-success:hover .bi-bag-check-fill {
            animation: bounce 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .form-select, .form-control {
            background: #495057;
            border: 2px solid #6c757d;
            color: #f8f9fa;
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            background: #5a6268;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            color: #f8f9fa;
        }

        .form-select option {
            background: #343a40;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid position-relative">
        <a class="navbar-brand d-flex align-items-center" href="accueil.php">
            <i class="bi bi-moon-stars fs-1 me-2"></i>
            <span class="fs-3 fw-bold text-light">NUIT DE L'INFO</span>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto d-none d-lg-flex align-items-center">
                <li class="nav-item me-2">
                    <a href="APropos.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="À propos">
                        <i class="bi bi-info-circle"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="chatBot/chatBotMain.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="ChatBot">
                        <i class="bi bi-chat-dots"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="qcm.php" class="btn btn-outline-light btn-lg active"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quiz">
                        <i class="bi bi-question-circle"></i>
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="moduleMateriel/moduleMaterielMain.php" class="btn btn-outline-light btn-lg"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Matériels">
                        <i class="bi bi-pc-display"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="btn-group dropstart">
                        <button class="btn btn-outline-light btn-lg dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                data-bs-toggle-second="tooltip" data-bs-placement="bottom" title="Compte">
                            <i class="bi bi-person"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="Connexion.php">
                                    <i class="bi bi-person-check-fill me-2"></i>Connexion
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="Inscription.php">
                                    <i class="bi bi-person-plus-fill me-2"></i>Inscription
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-lg-none mt-3 w-100">
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="APropos.php">
                        <i class="bi bi-info-circle"></i> À propos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="chatBot/chatBotMain.php">
                        <i class="bi bi-chat-dots"></i> ChatBot
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100 active" href="qcm.php">
                        <i class="bi bi-question-circle"></i> Quiz
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="btn btn-outline-light w-100" href="moduleMateriel/moduleMaterielMain.php">
                        <i class="bi bi-pc-display"></i> Matériels
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-light w-100 dropdown-toggle" href="#"
                       id="compteDropdown" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-person me-1"></i> Compte
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100" aria-labelledby="compteDropdown">
                        <li>
                            <a class="dropdown-item" href="Connexion.php">
                                <i class="bi bi-person-check-fill me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="Inscription.php">
                                <i class="bi bi-person-plus-fill me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr class="text-light">

<div class="quiz-container">
    <?php if (!$submitted): ?>
        <div class="quiz-hero">
            <h1><i class="bi bi-trophy-fill me-3"></i>Quiz Sportif NIRD</h1>
            <p class="lead fs-4 mb-0">Découvre ton profil et obtiens des recommandations personnalisées !</p>
        </div>

        <form method="POST" id="quizForm">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="quiz-card" style="animation-delay: 0.1s;">
                        <h3 class="mb-4"><i class="bi bi-person-fill me-2 text-primary"></i>Informations de base</h3>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sport principal</label>
                            <select name="sport" class="form-select">
                                <option>Musculation</option>
                                <option>Fitness</option>
                                <option>Yoga</option>
                                <option>Course</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ton objectif</label>
                            <input name="objectif" class="form-control" placeholder="Ex : prise de muscle, endurance...">
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="submit-btn">
                                <i class="bi bi-rocket-takeoff me-2"></i>Lancer le quiz
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="quiz-card" style="animation-delay: 0.2s;">
                        <h3 class="mb-4"><i class="bi bi-list-check me-2 text-success"></i>20 Questions</h3>
                        <p class="text-muted mb-4">Réponds honnêtement pour obtenir les meilleurs résultats</p>

                        <?php foreach ($questions as $i => $q): ?>
                            <div class="question-card" style="animation-delay: <?= 0.3 + ($i * 0.05) ?>s;">
                                <div class="d-flex align-items-start mb-3">
                                    <span class="question-number"><?= $i + 1 ?></span>
                                    <strong class="fs-5"><?= htmlspecialchars($q['q']) ?></strong>
                                </div>
                                <?php foreach ($q['options'] as $optIndex => $opt): ?>
                                    <label class="option-label">
                                        <input type="radio" name="<?= htmlspecialchars($q['name']) ?>"
                                               value="<?= $optIndex ?>" <?= $optIndex === 0 ? 'checked' : '' ?>>
                                        <span><?= htmlspecialchars($opt['t']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>

    <?php else: ?>
    <div class="quiz-hero">
        <h1><i class="bi bi-check-circle-fill me-3"></i>Résultats du Quiz</h1>
        <div class="mt-4">
            <div class="result-badge">
                Profil : <?= htmlspecialchars($profile) ?> (<?= $global_score ?>%)
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="quiz-card" style="animation-delay: 0.1s;">
                <h3 class="mb-4"><i class="bi bi-graph-up me-2 text-primary"></i>Ton profil détaillé</h3>

                <?php foreach ($percent as $d => $p): ?>
                    <div class="stat-card">
                        <div class="d-flex justify-content-between mb-2">
                            <strong class="text-capitalize"><?= $d ?></strong>
                            <span class="fw-bold text-primary"><?= $p ?>%</span>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" data-value="<?= $p ?>" style="width: 0%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="quiz-card mt-4" style="animation-delay: 0.3s;">
                <h3 class="mb-4"><i class="bi bi-lightbulb-fill me-2 text-warning"></i>Interprétation</h3>
                <ul class="list-unstyled">
                    <?php
                    foreach ($percent as $d => $p) {
                        $icon = $p < 35 ? 'arrow-down-circle' : ($p < 65 ? 'dash-circle' : 'arrow-up-circle');
                        $color = $p < 35 ? 'danger' : ($p < 65 ? 'warning' : 'success');
                        $text = $p < 35 ? 'À développer' : ($p < 65 ? 'Niveau correct' : 'Excellent niveau');
                        echo '<li class="mb-3 p-3 rounded" style="background: rgba(13, 110, 253, 0.05);">';
                        echo '<i class="bi bi-'.$icon.' text-'.$color.' me-2 fs-4"></i>';
                        echo '<strong class="text-capitalize">'.$d.'</strong> : ';
                        echo '<span class="text-'.$color.'">'.$text.'</span>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="quiz-card" style="animation-delay: 0.2s;">
                <h3 class="mb-4"><i class="bi bi-stars me-2 text-warning"></i>Recommandations</h3>
                <?php
                asort($percent);
                $weakest = array_key_first($percent);
                echo '<div class="alert alert-info" role="alert">';
                echo '<h5 class="alert-heading"><i class="bi bi-bullseye me-2"></i>Priorité</h5>';
                echo '<p class="mb-0">Travaille en priorité : <strong class="text-capitalize">'.$weakest.' ('.$percent[$weakest].'%)</strong></p>';
                echo '</div>';

                $advice = [
                        "endurance" => "Travail progressif de cardio (séances 20→40→60min), fractionné léger, augmentation progressive du volume.",
                        "force" => "Priorise mouvements poly-articulaires (squat, développé, tirage), charge progressive, 2-3x/semaine.",
                        "mobilite" => "Intègre 10-15min d'étirements dynamiques + travail de mobilité articulaire avant et après séance.",
                        "frequence" => "Augmente la fréquence progressivement : +1 séance toutes les 2 semaines si récupération ok.",
                        "experience" => "Travaille la technique : tutoriels vidéo, coaching ponctuel, attention à la technique."
                ];
                echo '<p class="lead">'.$advice[$weakest].'</p>';

                $sport_sel = htmlspecialchars($_POST['sport'] ?? 'Fitness');

                ?>

                <h3 class="mb-3"><i class="bi bi-cart-fill me-2 text-success"></i>Produits recommandés</h3>

                <?php
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

                // Affichage des produits
                echo '<div class="row g-3 mt-2">';
                if (isset($products[$sport_sel])) {
                    foreach ($products[$sport_sel] as $url => $label) {
                        $cleanUrl = trim($url);
                        if (filter_var($cleanUrl, FILTER_VALIDATE_URL)) {
                            echo '
                                    <div class="col-12">
                                        <a href="' . htmlspecialchars($cleanUrl) . '" target="_blank" 
                                           class="btn btn-outline-success w-100 text-start p-3 d-flex align-items-center" 
                                           style="transition: all 0.3s ease;">
                                            <i class="bi bi-bag-check-fill me-3 fs-4 text-success"></i>
                                            <div>
                                                <strong class="d-block">' . htmlspecialchars($label) . '</strong>
                                                <small class="text-muted">→ Voir sur Decathlon</small>
                                            </div>
                                        </a>
                                    </div>';
                        }
                    }
                } else {
                    echo '<div class="col-12"><p class="text-muted">Aucun produit configuré pour ce sport.</p></div>';
                }
                echo '</div>';
                ?>
            </div>
        </div>

        <div class="quiz-card mt-4" style="animation-delay: 0.4s;">
            <h3 class="mb-4"><i class="bi bi-play-circle-fill me-2 text-danger"></i>Vidéo : <?= $sport_sel ?></h3>
            <div class="video-container">
                <?php
                $vid = $video_by_sport[$sport_sel] ?? $video_by_sport['Fitness'];
                echo '<iframe src="'.htmlspecialchars($vid).'" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                ?>
            </div>
        </div>

        <?php if (isset($images[$sport_sel]) && file_exists($images[$sport_sel])): ?>
            <div class="quiz-card mt-4" style="animation-delay: 0.5s;">
                <h3 class="mb-4"><i class="bi bi-image-fill me-2 text-info"></i>Illustration</h3>
                <img src="<?= htmlspecialchars($images[$sport_sel]) ?>" class="img-fluid rounded" alt="<?= $sport_sel ?>">
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="text-center mt-5">
    <a href="qcm.php" class="submit-btn">
        <i class="bi bi-arrow-repeat me-2"></i>Refaire le quiz
    </a>
</div>
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Animate progress bars
        setTimeout(() => {
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const value = bar.getAttribute('data-value');
                bar.style.width = value + '%';
            });
        }, 300);

        // Smooth scroll to form on page load
        if (window.location.hash === '') {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
</script>

</body>
</html>