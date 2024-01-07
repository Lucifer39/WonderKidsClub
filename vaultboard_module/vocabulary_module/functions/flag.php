<?php 
    function change_topic($key, $topic){
        if($topic == "words"){
            if($key == "table"){
                return "dictionary";
            }
            else if($key == "wordset"){
                return "wordset";
            }
            else if($key == "id"){
                return "word_id";
            }
            else if($key == "questions"){
                return "questions";
            }
            else if($key == "leaderboard"){
                return "leaderboard_words";
            }
            else if($key == "student_table"){
                return "vocab_students";
            }
            else if($key == "main_table_col"){
                return "word";
            }
        }

        else if($topic == "idioms"){
            if($key == "table"){
                return "vocab_idioms";
            }
            else if($key == "wordset"){
                return "vocab_idioms_wordset";
            }
            else if($key == "id"){
                return "idiom_id";
            }
            else if($key == "questions"){
                return "vocab_question_idioms";
            }
            else if($key == "leaderboard"){
                return "leaderboard_idioms";
            }
            else if($key == "student_table"){
                return "vocab_students_idioms";
            }
            else if($key == "main_table_col"){
                return "idiom";
            }
        }

        else if($topic == "simile"){
            if($key == "table"){
                return "vocab_simile";
            }
            else if($key == "wordset"){
                return "vocab_simile_wordset";
            }
            else if($key == "id"){
                return "simile_id";
            }
            else if($key == "questions"){
                return "vocab_question_simile";
            }
            else if($key == "leaderboard"){
                return "leaderboard_simile";
            }
            else if($key == "student_table"){
                return "vocab_students_simile";
            }
            else if($key == "main_table_col"){
                return "simile";
            }
        }

        else if($topic == "metaphor"){
            if($key == "table"){
                return "vocab_metaphor";
            }
            else if($key == "wordset"){
                return "vocab_metaphor_wordset";
            }
            else if($key == "id"){
                return "metaphor_id";
            }
            else if($key == "questions"){
                return "vocab_question_metaphor";
            }
            else if($key == "leaderboard"){
                return "leaderboard_metaphor";
            }
            else if($key == "student_table"){
                return "vocab_students_metaphor";
            }
            else if($key == "main_table_col"){
                return "metaphor";
            }
        }

        else if($topic == "hyperbole"){
            if($key == "table"){
                return "vocab_hyperbole";
            }
            else if($key == "wordset"){
                return "vocab_hyperbole_wordset";
            }
            else if($key == "id"){
                return "hyperbole_id";
            }
            else if($key == "questions"){
                return "vocab_question_hyperbole";
            }
            else if($key == "leaderboard"){
                return "leaderboard_hyperbole";
            }
            else if($key == "student_table"){
                return "vocab_students_hyperbole";
            }
            else if($key == "main_table_col"){
                return "hyperbole";
            }
        }
    }
?>