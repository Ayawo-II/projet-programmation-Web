<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'student')->get();
        $tags  = Tag::all();

        $questions = [
            [
                'title' => 'Comment résoudre une équation différentielle du second ordre ?',
                'body'  => "Je bloque sur la résolution des équations différentielles du second ordre à coefficients constants. J'ai compris le cas homogène mais je ne comprends pas comment trouver la solution particulière quand le second membre est un polynôme. Quelqu'un peut m'expliquer la méthode ?",
                'tags'  => ['Mathématiques'],
                'solved'=> true,
            ],
            [
                'title' => 'Quelle est la différence entre la complexité O(n) et O(n log n) ?',
                'body'  => "Dans mon cours d'algorithmique, on parle de complexité temporelle. Je comprends O(n) mais j'ai du mal à visualiser O(n log n). Est-ce que quelqu'un peut me donner un exemple concret et m'expliquer pourquoi le tri fusion est O(n log n) ?",
                'tags'  => ['Informatique'],
                'solved'=> false,
            ],
            [
                'title' => 'Comment appliquer le théorème de Bayes en probabilités ?',
                'body'  => "Je sèche sur un exercice de probabilités conditionnelles. L'énoncé parle de maladie rare avec test de dépistage. Le test est positif à 95% si malade, et faux positif à 2%. La prévalence est 0.1%. On me demande la proba d'être malade si le test est positif. Comment appliquer Bayes ici ?",
                'tags'  => ['Mathématiques', 'Statistiques'],
                'solved'=> true,
            ],
            [
                'title' => "Qu'est-ce que le polymorphisme en programmation orientée objet ?",
                'body'  => "Mon prof a mentionné le polymorphisme comme un des piliers de la POO mais je ne vois pas concrètement à quoi ça sert. J'ai un exemple avec des classes Animal, Chien et Chat mais je ne comprends pas l'intérêt par rapport à faire des fonctions séparées.",
                'tags'  => ['Informatique'],
                'solved'=> false,
            ],
            [
                'title' => 'Comment équilibrer une équation chimique de combustion ?',
                'body'  => "Je n'arrive pas à équilibrer l'équation de combustion du méthane. J'ai CH4 + O2 → CO2 + H2O mais je ne sais pas comment trouver les bons coefficients stœchiométriques. Y a-t-il une méthode systématique ?",
                'tags'  => ['Chimie'],
                'solved'=> true,
            ],
            [
                'title' => 'Différence entre le PIB et le PNB en économie ?',
                'body'  => "Mon cours d'économie distingue le PIB et le PNB mais je confonds les deux. Dans quel cas utilise-t-on l'un plutôt que l'autre ? Est-ce que quelqu'un peut me donner un exemple concret pour un pays comme la France ?",
                'tags'  => ['Économie'],
                'solved'=> false,
            ],
            [
                'title' => 'Comment fonctionne la photosynthèse au niveau cellulaire ?',
                'body'  => "Je comprends le schéma global (CO2 + lumière → glucose + O2) mais mon cours de biologie va plus loin avec la chaîne photosynthétique, les photosystèmes I et II, le cycle de Calvin... Comment tout ça s'articule-t-il ?",
                'tags'  => ['Biologie'],
                'solved'=> false,
            ],
            [
                'title' => 'Quelle est la loi applicable à un contrat international de vente ?',
                'body'  => "Dans mon cours de droit international privé, on étudie les conflits de lois. Si un vendeur français vend à un acheteur allemand via internet, quelle loi s'applique au contrat ? Est-ce que le règlement Rome I s'applique toujours ?",
                'tags'  => ['Droit'],
                'solved'=> false,
            ],
        ];

        foreach ($questions as $i => $data) {
            $author   = $users[$i % $users->count()];
            $question = Question::create([
                'user_id'   => $author->id,
                'title'     => $data['title'],
                'body'      => $data['body'],
                'is_solved' => $data['solved'],
                'views'     => rand(10, 300),
            ]);

            // Attacher les tags
            $tagIds = Tag::whereIn('name', $data['tags'])->pluck('id');
            $question->tags()->attach($tagIds);

            // Ajouter des réponses
            $otherUsers = $users->where('id', '!=', $author->id)->values();
            $nbAnswers  = rand(1, 3);

            for ($j = 0; $j < $nbAnswers; $j++) {
                $responder = $otherUsers[$j % $otherUsers->count()];
                $answer    = Answer::create([
                    'question_id' => $question->id,
                    'user_id'     => $responder->id,
                    'body'        => "Voici une réponse détaillée à votre question numéro " . ($i + 1) . ". La clé est de bien comprendre les fondamentaux du cours et de pratiquer avec des exercices similaires. N'hésitez pas à poser des questions de suivi si quelque chose n'est pas clair.",
                    'is_accepted' => $data['solved'] && $j === 0,
                ]);

                // Votes sur les réponses
                $voters = $users->where('id', '!=', $responder->id)->take(3);
                foreach ($voters as $voter) {
                    Vote::create([
                        'user_id'      => $voter->id,
                        'votable_id'   => $answer->id,
                        'votable_type' => 'App\Models\Answer',
                        'value'        => rand(0, 1) ? 1 : -1,
                    ]);
                }
            }

            // Votes sur la question
            $voters = $users->where('id', '!=', $author->id)->take(4);
            foreach ($voters as $voter) {
                Vote::create([
                    'user_id'      => $voter->id,
                    'votable_id'   => $question->id,
                    'votable_type' => 'App\Models\Question',
                    'value'        => rand(0, 3) ? 1 : -1,
                ]);
            }
        }
    }
}