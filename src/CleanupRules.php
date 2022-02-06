<?php
namespace Janakdom\CleanUpComposer;

class CleanupRules
{
    const _docs = 'README* CHANGELOG* FAQ* CONTRIBUTING* HISTORY* UPGRADING* UPGRADE* package* demo example examples doc docs readme* changelog* composer*';
    const _tests = '.travis.yml .scrutinizer.yml phpcs.xml* phpcs.php phpunit.xml* phpunit.php test tests Tests travis patchwork.json';
    const _others = 'LICENSE* .github SECURITY*';

    public static function getRules($packageName)
    {
        if($packageName == "composer") {;
            return [
                str_replace('package* ', '', self::_docs),
                self::_tests,
                self::_others
            ];
        }

        $specials = [
            'tecnickcom/tcpdf'                      => 'fonts',
            'anahkiasen/html-object'                => 'phpunit.xml* tests/*',
            'doctrine/annotations'                  => 'bin',
            'doctrine/cache'                        => 'bin',
            'doctrine/common'                       => 'bin lib/vendor',
            'doctrine/dbal'                         => 'bin build* docs2 lib/vendor',
            'dompdf/dompdf'                         => 'www',
            'imagine/imagine'                       => 'lib/Imagine/Test',
            'intervention/image'                    => 'public',
            'jakub-onderka/php-console-color'       => 'build.xml example.php',
            'jakub-onderka/php-console-highlighter' => 'build.xml',
            'jeremeamia/SuperClosure'               => 'demo',
            'laravel/framework'                     => 'build',
            'leafo/lessphp'                         => 'Makefile package.sh',
            'maximebf/debugbar'                     => 'demo',
            'mrclay/minify'                         => 'MIN.txt min_extras min_unit_tests min/builder min/config* min/quick-test* min/utils.php min/groupsConfig.php min/index.php',
            'mustache/mustache'                     => 'bin',
            'nikic/php-parser'                      => 'test_old',
            'phenx/php-font-lib'                    => 'www',
            'phpoffice/phpexcel'                    => 'Examples unitTests changelog.txt',
            'phpoffice/phpspreadsheet'              => 'samples',
            'phpseclib/phpseclib'                   => 'build',
            'predis/predis'                         => 'bin',
            'quickbooks/v3-php-sdk'                 => 'docs docs/* src/XSD2PHP/test src/XSD2PHP/test/*',
            'simplepie/simplepie'                   => 'build compatibility_test ROADMAP.md',
            'swiftmailer/swiftmailer'               => 'build* notes test-suite create_pear_package.php'
        ];

        $out = [self::_docs, self::_tests, self::_others];
        if(in_array($packageName, $specials)) {
            $out[] = $specials[$packageName];
        }
        return $out;
    }
}
