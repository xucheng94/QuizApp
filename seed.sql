-- ============================================================
-- SEED USERS
-- ============================================================

INSERT INTO users (email, password_hash, is_admin, username, first_name, last_name) VALUES
('admin@quizone.com', '$2y$10$tmYIJwSlFQ.pzashvPsszuySLXiUEY885VfpDfNy8XX1Nbo5WmNeG', 1, 'instructor_01', 'Jane', 'Admin'),
('admin2@quizone.com', '$2y$10$CIgXfrjj8w9E8VfFQGqwG.vB96BsduEng7Ilf7ixp0CId5lmhvxeS', 1, 'instructor_02', 'Alice', 'Admin'),
('admin3@quizone.com', '$2y$10$0RlS3ln2ZUp1rG141TQJC.zWLBlYcMgWP7SN3ZmjyuJ6N/6BEgsLO', 1, 'instructor_03', 'Bob', 'Admin'),
('user1@example.com', '$2y$10$4Nss6MILtqPwMzUV2G14XefdRt01qpDw7HSTsp5Hb0t6IkrePWyB6', 0, 'user1', 'John', 'Doe'),
('user2@example.com', '$2y$10$DSDNGdKf83OgDmke1zotg.KS6syCLyUNfYWO9D1F9uVowjdtevPhy', 0, 'user2', 'Sarah', 'Smith'),
('user3@example.com', '$2y$10$KJ/c9HO2Mf7dEVh58w474OOk/js4pYBHvyW.kNqpLoTDGPC/GKl8m', 0, 'user3', 'David', 'Jones'),
('user4@example.com', '$2y$10$Q53IO1P995POaritiLKGxOFWcawCli0wPthV3XakrKk.CMw6Q6FJy', 0, 'user4', 'Emily', 'Clark');

-- ============================================================
-- SEED SUBJECTS
-- ============================================================

INSERT INTO subject_categories (title, description) VALUES
('Mathematics', 'Explore branches such as Algebra, Calculus, and Trigonometry.'),
('Science', 'Covers Physics, Chemistry, and Biology fundamentals.'),
('History', 'World, ancient, and modern history topics.'),
('Language Arts', 'English comprehension, grammar, and writing.');

INSERT INTO subjects (category_id, title, subject_details, sort_order) VALUES
(1, 'Algebra', 'Expressions, equations, and functions.', 1),
(1, 'Calculus', 'Limits, derivatives, and integrals.', 2),
(1, 'Trigonometry', 'Angles, identities, and periodic functions.', 3);


INSERT INTO subjects (category_id, title, subject_details, sort_order) VALUES
(2, 'Physics', 'Motion, forces, and energy.', 1),
(2, 'Chemistry', 'Atoms, chemical reactions, and bonding.', 2),
(2, 'Biology', 'Cells, life processes, and ecosystems.', 3);

INSERT INTO subjects (category_id, title, subject_details, sort_order) VALUES
(3, 'Ancient History', 'Origins of civilizations and early societies.', 1),
(3, 'Modern History', 'Industrial era to the 21st century.', 2),
(3, 'World History', 'Global perspectives across eras.', 3);

INSERT INTO subjects (category_id, title, subject_details, sort_order) VALUES
(4, 'Grammar', 'Foundations of sentence structure.', 1),
(4, 'Reading Comprehension', 'Understanding texts and passages.', 2),
(4, 'Writing Skills', 'Composition, structure, and clarity.', 3);

-- ============================================================
-- SEED QUIZZES (1 quiz per subject)
-- ============================================================

-- Algebra (subject_id = 1)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(1, 'Algebra Basics', 'Test your understanding of fundamental algebra concepts.', 'Beginner', 1);

-- Calculus (subject_id = 2)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(2, 'Intro to Calculus', 'Covers limits, derivatives, and basic applications.', 'Intermediate', 1);

-- Trigonometry (subject_id = 3)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(3, 'Trigonometry Essentials', 'Angles, identities, and right-triangle relationships.', 'Intermediate', 1);


-- Physics (subject_id = 4)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(4, 'Physics Fundamentals', 'Motion, force, and Newton’s laws.', 'Mixed', 1);

-- Chemistry (subject_id = 5)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(5, 'Chemistry Concepts', 'Atoms, reactions, bonding basics.', 'Mixed', 1);

-- Biology (subject_id = 6)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(6, 'Biology Foundations', 'Cells, life processes, and organisms.', 'Beginner', 1);


-- Ancient History (subject_id = 7)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(7, 'Ancient Civilizations', 'Egypt, Mesopotamia, and early empires.', 'Beginner', 1);

-- Modern History (subject_id = 8)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(8, 'Modern World Quiz', 'Industrial era through modern conflicts.', 'Intermediate', 1);

-- World History (subject_id = 9)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(9, 'Global History Overview', 'Major global events across eras.', 'Mixed', 1);


-- Grammar (subject_id = 10)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(10, 'English Grammar Basics', 'Parts of speech, punctuation, and syntax.', 'Beginner', 1);

-- Reading Comprehension (subject_id = 11)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(11, 'Reading Comprehension Test', 'Short passages with analytical questions.', 'Intermediate', 1);

-- Writing Skills (subject_id = 12)
INSERT INTO quizzes (subject_id, title, explanation, difficulty, sort_order) VALUES
(12, 'Writing Skills Check', 'Clarity, structure, and composition.', 'Intermediate', 1);


-- ============================================================
-- SEED QUESTIONS + ANSWERS
-- (3 questions per quiz)
-- ============================================================

/* ========================
   QUIZ 1 — Algebra Basics
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(1, 'What is the value of x in the equation 2x + 4 = 10?', 1),
(1, 'Simplify: 3(a + 2)', 2),
(1, 'Which of the following is a linear equation?', 3);

-- Options for Q1
INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(1, '2', 0),
(1, '3', 1),
(1, '4', 0),
(1, '6', 0);

-- Options for Q2
INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(2, '3a + 2', 0),
(2, '3a + 6', 1),
(2, 'a + 6', 0),
(2, '6a + 3', 0);

-- Options for Q3
INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(3, 'x² + 5', 0),
(3, '2x - 7 = 0', 1),
(3, 'x³ - 4x', 0),
(3, 'x⁴ - 16', 0);


/* ========================
   QUIZ 2 — Intro to Calculus
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(2, 'What is the limit of (x → 0) sin(x)/x?', 1),
(2, 'The derivative of x² is:', 2),
(2, 'The concept of instantaneous rate of change refers to:', 3);

-- Options
INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(4, '0', 0),
(4, '1', 1),
(4, 'Undefined', 0),
(4, 'x', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(5, '2x', 1),
(5, 'x²', 0),
(5, 'x', 0),
(5, '2', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(6, 'Derivative', 1),
(6, 'Integral', 0),
(6, 'Limit', 0),
(6, 'Slope formula', 0);


/* ========================
   QUIZ 3 — Trigonometry Essentials
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(3, 'What is sin(90°)?', 1),
(3, 'cos(0°) equals:', 2),
(3, 'Which is a trigonometric identity?', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(7, '0', 0),
(7, '1', 1),
(7, '-1', 0),
(7, 'Undefined', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(8, '0', 0),
(8, '1', 1),
(8, '0.5', 0),
(8, 'Undefined', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(9, 'sin²x + cos²x = 1', 1),
(9, 'sinx = tanx', 0),
(9, 'cosx = 0 always', 0),
(9, 'tanx = 1 always', 0);


/* ========================
   QUIZ 4 — Physics Fundamentals
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(4, 'Force equals mass times?', 1),
(4, 'Which is a unit of force?', 2),
(4, 'Newton’s First Law is also known as:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(10, 'Speed', 0),
(10, 'Velocity', 0),
(10, 'Acceleration', 1),
(10, 'Distance', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(11, 'Joule', 0),
(11, 'Newton', 1),
(11, 'Watt', 0),
(11, 'Volt', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(12, 'Law of inertia', 1),
(12, 'Law of gravity', 0),
(12, 'Law of momentum', 0),
(12, 'Law of energy', 0);


/* ========================
   QUIZ 5 — Chemistry Concepts
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(5, 'What is the atomic number?', 1),
(5, 'Water is made of:', 2),
(5, 'NaCl is commonly known as:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(13, 'Number of protons', 1),
(13, 'Number of neutrons', 0),
(13, 'Number of electrons', 0),
(13, 'Mass number', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(14, 'H and O', 1),
(14, 'C and O', 0),
(14, 'Na and Cl', 0),
(14, 'H and N', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(15, 'Sugar', 0),
(15, 'Salt', 1),
(15, 'Baking soda', 0),
(15, 'Vinegar', 0);


/* ========================
   QUIZ 6 — Biology Foundations
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(6, 'The basic unit of life is:', 1),
(6, 'Plants produce food by:', 2),
(6, 'DNA is found in the:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(16, 'Cell', 1),
(16, 'Organ', 0),
(16, 'Tissue', 0),
(16, 'System', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(17, 'Respiration', 0),
(17, 'Digestion', 0),
(17, 'Photosynthesis', 1),
(17, 'Circulation', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(18, 'Nucleus', 1),
(18, 'Ribosome', 0),
(18, 'Golgi body', 0),
(18, 'Mitochondria', 0);


/* ========================
   QUIZ 7 — Ancient Civilizations
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(7, 'The pyramids were built in:', 1),
(7, 'Mesopotamia is located between:', 2),
(7, 'The first writing system was:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(19, 'Rome', 0),
(19, 'Egypt', 1),
(19, 'Greece', 0),
(19, 'Persia', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(20, 'Nile and Amazon', 0),
(20, 'Tigris and Euphrates', 1),
(20, 'Danube and Rhine', 0),
(20, 'Yangtze and Yellow River', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(21, 'Hieroglyphics', 0),
(21, 'Cuneiform', 1),
(21, 'Latin', 0),
(21, 'Sanskrit', 0);


/* ========================
   QUIZ 8 — Modern World Quiz
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(8, 'World War II ended in:', 1),
(8, 'The Industrial Revolution began in:', 2),
(8, 'The Cold War was mainly between:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(22, '1918', 0),
(22, '1945', 1),
(22, '1950', 0),
(22, '1939', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(23, 'USA', 0),
(23, 'Germany', 0),
(23, 'UK', 1),
(23, 'France', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(24, 'USA & USSR', 1),
(24, 'USA & China', 0),
(24, 'UK & France', 0),
(24, 'Russia & Japan', 0);


/* ========================
   QUIZ 9 — Global History Overview
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(9, 'Which empire was the largest in history?', 1),
(9, 'Silk Road connected China with:', 2),
(9, 'The Renaissance began in:', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(25, 'Roman Empire', 0),
(25, 'British Empire', 1),
(25, 'Ottoman Empire', 0),
(25, 'Mongol Empire', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(26, 'India', 1),
(26, 'Japan', 0),
(26, 'Greece', 0),
(26, 'Russia', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(27, 'France', 0),
(27, 'Italy', 1),
(27, 'Spain', 0),
(27, 'Germany', 0);


/* ========================
   QUIZ 10 — English Grammar Basics
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(10, 'Which is a noun?', 1),
(10, 'Which sentence is punctuated correctly?', 2),
(10, 'Identify the verb: "The dog ran quickly."', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(28, 'Happy', 0),
(28, 'Jump', 0),
(28, 'Car', 1),
(28, 'Blue', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(29, 'I like apples, bananas and grapes.', 0),
(29, 'I like apples bananas, and grapes.', 0),
(29, 'I like apples, bananas, and grapes.', 1),
(29, 'I like apples bananas and, grapes.', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(30, 'Dog', 0),
(30, 'Ran', 1),
(30, 'Quickly', 0),
(30, 'The', 0);


/* ========================
   QUIZ 11 — Reading Comprehension Test
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(11, 'What is the main idea of a passage?', 1),
(11, 'Which detail supports an argument?', 2),
(11, 'What does “imply” mean?', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(31, 'The central point the author makes.', 1),
(31, 'A random fact.', 0),
(31, 'A summary.', 0),
(31, 'A prediction.', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(32, 'A statement unrelated to the topic.', 0),
(32, 'A fact that strengthens the claim.', 1),
(32, 'An opinion.', 0),
(32, 'A joke.', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(33, 'Say directly.', 0),
(33, 'Suggest without stating.', 1),
(33, 'Contradict.', 0),
(33, 'Explain in detail.', 0);


/* ========================
   QUIZ 12 — Writing Skills Check
   ======================== */

INSERT INTO questions (quiz_id, question_text, sort_order) VALUES
(12, 'Which is a complete sentence?', 1),
(12, 'A thesis statement should:', 2),
(12, 'Which improves clarity?', 3);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(34, 'Running fast.', 0),
(34, 'The boy ran home.', 1),
(34, 'Because it rained.', 0),
(34, 'After the match.', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(35, 'Explain the entire essay.', 0),
(35, 'State the main argument.', 1),
(35, 'Be as long as possible.', 0),
(35, 'List every example.', 0);

INSERT INTO answer_options (question_id, option_text, is_correct) VALUES
(36, 'Using shorter sentences.', 1),
(36, 'Adding more adjectives.', 0),
(36, 'Using passive voice.', 0),
(36, 'Making sentences longer.', 0);






