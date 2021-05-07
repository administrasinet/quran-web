<?php
require __DIR__ . '/SurahGenerator.php';
define('BASE_DIR', realpath(__DIR__ . '/../..'));

function env($envName, $default = null)
{
    if (isset($_SERVER[$envName])) {
        return $_SERVER[$envName];
    }

    return $default;
}

$config = [
    'quranJsonDir' => BASE_DIR . '/qurann/quran-json',
    'baseUrl' => 'https://administrasi.net/quran',
    'baseMurottalUrl' => 'https://administrasi.net/quran/murottal',
    'buildDir' => BASE_DIR . '/build',
    'publicDir' => BASE_DIR . '/src/public',
    'templateDir' => env('QURAN_TEMPLATE_DIR', BASE_DIR . '/quran-web/src/generator/template'),
    'beginSurah' => env('QURAN_BEGIN_SURAH', 1),
    'endSurah' => env('QURAN_END_SURAH', 114),
    'githubProjectUrl' => env('QURAN_GITHUB_PROJECT_URL', 'https://github.com/administrasinet/quran-web'),
    'analyticsId' => env('QURAN_ANALYTICS_ID'),
    'ogImageUrl' => env('QURAN_OG_IMAGE_URL', 'https://s3-ap-southeast-1.amazonaws.com/quranweb/quranweb-1024.png')
];

echo "Generating website...";
try {
    $generator = new SurahGenerator($config);
    $generator->copyPublic();
    $generator->makeSurah();
    echo "done.\n";
} catch (Exception $e) {
    echo "FAIL.\n";
    printf("Error: %s\n", $e->getMessage());
}
