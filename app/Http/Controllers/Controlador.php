<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_YouTube;
use DateInterval;

class Controlador extends Controller
{

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request)
    {
        if (isset($request->parametro) && isset($request->maximo)) {
            $DEVELOPER_KEY = '';
            $cliente = new Google_Client();
            $cliente->setDeveloperKey($DEVELOPER_KEY);

            $youtubeService = new Google_Service_YouTube($cliente);
            $titulosDescricoes = "";


            $resultadosPesquisa = $youtubeService->search->listSearch(
                'id,snippet',
                [
                    'q' => $request->parametro,
                    'maxResults' => $request->maximo,
                ]
            );

            $videos = [];

            foreach ($resultadosPesquisa['items'] as $resultadoPesquisa) {
                if ($resultadoPesquisa['id']['kind'] == 'youtube#video') {
                    $parametros = [
                        'id' => $resultadoPesquisa['id']['videoId']
                    ];

                    $video = $youtubeService->videos->listVideos('contentDetails', $parametros);
                    $tempo = $video['items'][0]['contentDetails']['duration'];

                    $duracao = new DateInterval($tempo);

                    $videos[] = [
                        'title' => $resultadoPesquisa['snippet']['title'],
                        'videoId' => $resultadoPesquisa['id']['videoId'],
                        'tags' => $resultadoPesquisa['snippet']['tags'],
                        'duration' => $duracao->format('%H:%i:%s')
                    ];

                    $titulosDescricoes .= ' ' . $resultadoPesquisa['snippet']['description'];
                    $titulosDescricoes .= ' ' . $resultadoPesquisa['snippet']['title'];
                }
            }


            $termosUtilizados = array_count_values(str_word_count($titulosDescricoes, 1));
            $termosUtilizados = $this->removeParavrasUsoComum($termosUtilizados);


            $diasSemana = [
                1 => 'Domingo',
                2 => 'Segunda',
                3 => 'Terça',
                4 => 'Quarta',
                5 => 'Quinta',
                6 => 'Sexta',
                7 => 'Sabado'
            ];

            arsort($termosUtilizados);
            $termosUtilizados = array_slice($termosUtilizados, 0, 5);
            $termosUtilizados = array_keys($termosUtilizados);

            $colecaoVideos = collect($videos);
            $diasTempo = collect($request->tempo);
            $totalDias = 0;
            $diasAssistindo = [];

            for ($i = 0; $i < count($diasTempo); $i++) {
                $totalDias++;
                $tempoDia = strtotime(gmdate("H:i:s", ($diasTempo[$i] * 60)));

                if ($i == 6 && count($colecaoVideos) > 0) {
                    $i = 0;
                }

                $tempoMaximo = strtotime(gmdate("H:i:s", ($diasTempo->max() * 60)));

                foreach ($colecaoVideos as $key =>  $video) {

                    if (strtotime($video['duration']) > $tempoMaximo) {
                        unset($colecaoVideos[$key]);
                        continue;
                    } else {
                        if (strtotime($video['duration']) <= $tempoDia) {
                            $diasAssistindo[$totalDias][] = [
                                'titulo' => $video['title'],
                                'duracao' => $video['duration'],
                                'diaAssistido' => $diasSemana[$i + 1]
                            ];

                            $totalDiasFinal = $totalDias;
                            $tempoDia = strtotime(gmdate("H:i:s", $tempoDia - strtotime($video['duration'])));

                            unset($colecaoVideos[$key]);
                        } else {
                            continue;
                            continue;
                        }
                    }
                }
            }
        }

        return view('teste.resultado', compact(
            [
                'totalDiasFinal',
                'diasAssistindo',
                'termosUtilizados'
            ]
        ));
    }

    private function removeParavrasUsoComum(array $palavras)
    {
        $usosComuns = [
            'o',
            'a',
            'os',
            'as',
            '-',
            'e',
            'do',
            'de',
            'da',
            'dos',
            'das',
            'para',
            'no',
            'na',
            'nos',
            'nas'
        ];

        foreach ($usosComuns as $palavra) {
            unset($palavras[$palavra]);
        }

        return $palavras;
    }
}
