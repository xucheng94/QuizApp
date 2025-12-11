<?php
/**
 * Seed script for inserting hardcoded quizzes, questions, and options.
 * 
 * Run using:
 *      php seed_questions.php
 */

// ---------------------------------------------------------------
// 1. DB CONFIG
// ---------------------------------------------------------------
$host = 'localhost';
$db   = 'quiz_app';
$user = 'root';
$pass = '';   // edit if needed
$charset = 'utf8mb4';

// ---------------------------------------------------------------
// 2. CONNECT TO DATABASE (PDO)
// ---------------------------------------------------------------
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to database.\n\n";
} catch (\PDOException $e) {
    exit("Connection failed: " . $e->getMessage() . "\n");
}



// ---------------------------------------------------------------
// 3. DEFINE QUIZ + QUESTIONS + OPTIONS STRUCTURE
// ---------------------------------------------------------------
$quizContent = [

    // ============================================================
    // TRIGONOMETRY SUBJECT
    // ============================================================
    "Trigonometry" => [

        "Trigonometry Basics" => [
            [
                "question" => "What is sin(0°)?",
                "options" => [
                    ["0", 1],
                    ["1", 0],
                    ["Undefined", 0],
                    ["0.5", 0]
                ]
            ],
            [
                "question" => "What is cos(90°)?",
                "options" => [
                    ["0", 1],
                    ["1", 0],
                    ["-1", 0],
                    ["Undefined", 0]
                ]
            ]
        ],

        "Advanced Trigonometry" => [
            [
                "question" => "What is the identity for sin²θ + cos²θ?",
                "options" => [
                    ["1", 1],
                    ["0", 0],
                    ["tanθ", 0],
                    ["secθ", 0]
                ]
            ],
            [
                "question" => "What does tanθ equal?",
                "options" => [
                    ["sinθ / cosθ", 1],
                    ["cosθ / sinθ", 0],
                    ["1 / sinθ", 0],
                    ["1 / cosθ", 0]
                ]
            ]
        ]
    ],



    // ============================================================
    // CALCULUS SUBJECT
    // ============================================================
    "Calculus" => [

        "Calculus I" => [
            [
                "question" => "What is the derivative of x²?",
                "options" => [
                    ["2x", 1],
                    ["x", 0],
                    ["x²", 0],
                    ["0", 0]
                ]
            ]
        ],

        "Calculus II" => [
            [
                "question" => "The integral of 1/x dx equals:",
                "options" => [
                    ["ln|x| + C", 1],
                    ["x ln|x|", 0],
                    ["1/(x²)", 0],
                    ["x² / 2", 0]
                ]
            ]
        ]
    ],



    // ============================================================
    // CHEMISTRY SUBJECT
    // ============================================================
    "Chemistry" => [

        "Chemistry Basics" => [
            [
                "question" => "What is the chemical symbol for water?",
                "options" => [
                    ["H₂O", 1],
                    ["O₂", 0],
                    ["CO₂", 0],
                    ["HO", 0]
                ]
            ]
        ],

        "Organic Chemistry" => [
            [
                "question" => "Which element is central to organic chemistry?",
                "options" => [
                    ["Carbon", 1],
                    ["Oxygen", 0],
                    ["Hydrogen", 0],
                    ["Nitrogen", 0]
                ]
            ]
        ]
    ],



    // ============================================================
    // PHYSICS SUBJECT
    // ============================================================
    "Physics" => [

        "Physics Fundamentals" => [
            [
                "question" => "What is the unit of force?",
                "options" => [
                    ["Newton", 1],
                    ["Joule", 0],
                    ["Watt", 0],
                    ["Pascal", 0]
                ]
            ]
        ],

        "Quantum Physics" => [
            [
                "question" => "What particle is associated with electromagnetic force?",
                "options" => [
                    ["Photon", 1],
                    ["Electron", 0],
                    ["Neutron", 0],
                    ["Proton", 0]
                ]
            ]
        ]
    ],



    // ============================================================
    // BIOLOGY SUBJECT
    // ============================================================
    "Biology" => [

        "Biology Foundations" => [
            [
                "question" => "What is the basic unit of life?",
                "options" => [
                    ["Cell", 1],
                    ["Organ", 0],
                    ["Organism", 0],
                    ["Tissue", 0]
                ]
            ]
        ],

        "Human Anatomy" => [
            [
                "question" => "Which organ pumps blood throughout the body?",
                "options" => [
                    ["Heart", 1],
                    ["Lung", 0],
                    ["Kidney", 0],
                    ["Brain", 0]
                ]
            ]
        ]
    ],
];



// ---------------------------------------------------------------
// 4. INSERT HELPERS
// ---------------------------------------------------------------
function insertQuiz($pdo, $subjectId, $title)
{
    $stmt = $pdo->prepare("
        INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order)
        VALUES (?, ?, '', 'Mixed', 0)
    ");
    $stmt->execute([$subjectId, $title]);
    return $pdo->lastInsertId();
}

function insertQuestion($pdo, $quizId, $text)
{
    $stmt = $pdo->prepare("
        INSERT INTO questions (question_text, quiz_id, sort_order, explanation)
        VALUES (?, ?, 0, NULL)
    ");
    $stmt->execute([$text, $quizId]);
    return $pdo->lastInsertId();
}

function insertOption($pdo, $questionId, $text, $correct)
{
    $stmt = $pdo->prepare("
        INSERT INTO options (is_correct, question_id, option_text)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$correct, $questionId, $text]);
}



// ---------------------------------------------------------------
// 5. MAIN SEEDING LOGIC
// ---------------------------------------------------------------

foreach ($quizContent as $subjectTitle => $quizzes) {

    // Find subject ID
    $stmt = $pdo->prepare("SELECT id FROM subjects WHERE title = ?");
    $stmt->execute([$subjectTitle]);
    $subject = $stmt->fetch();

    if (!$subject) {
        echo "Subject not found: $subjectTitle\n";
        continue;
    }

    $subjectId = $subject['id'];
    echo "Seeding subject: $subjectTitle (ID $subjectId)\n";

    // Insert quizzes + questions + options
    foreach ($quizzes as $quizTitle => $questions) {

        $quizId = insertQuiz($pdo, $subjectId, $quizTitle);
        echo "  → Quiz: $quizTitle (ID $quizId)\n";

        foreach ($questions as $q) {

            $questionId = insertQuestion($pdo, $quizId, $q["question"]);
            echo "      - Question inserted\n";

            foreach ($q["options"] as $opt) {
                insertOption($pdo, $questionId, $opt[0], $opt[1]);
            }
        }
    }
}

echo "\nSeeding complete.\n";

?>