<?php
$states = json_decode(file_get_contents('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome'), true);

$result = [];

foreach ($states as $state) {
    $uf = $state['sigla'];
    echo "Buscando cidades de {$state['nome']} ($uf)...\n";

    $cities = json_decode(
        file_get_contents("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios"),
        true
    );

    $names = array_map(fn($c) => $c['nome'], $cities);
    sort($names);

    $result[$uf] = $names;
}

ksort($result);

file_put_contents(__DIR__ . '/brazil-locations.json', json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "Pronto! brazil-locations.json gerado.\n";