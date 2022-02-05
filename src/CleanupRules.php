<?php
namespace Janakdom\Composer;

class CleanupRules
{
    public static function getRules($packageName)
    {
        // Default patterns for common files
        $docs = 'README* CHANGELOG* FAQ* CONTRIBUTING* HISTORY* UPGRADING* UPGRADE* package* demo example examples doc docs readme* changelog* composer*';
        $tests = '.travis.yml .scrutinizer.yml phpcs.xml* phpcs.php phpunit.xml* phpunit.php test tests Tests travis patchwork.json';

        $specials = [
            'tecnickcom/tcpdf'                      => [$docs, $tests, 'fonts'],
            'anahkiasen/html-object'                => [$docs, 'phpunit.xml* tests/*'],
            'doctrine/annotations'                  => [$docs, $tests, 'bin'],
            'doctrine/cache'                        => [$docs, $tests, 'bin'],
            'doctrine/common'                       => [$docs, $tests, 'bin lib/vendor'],
            'doctrine/dbal'                         => [$docs, $tests, 'bin build* docs2 lib/vendor'],
            'dompdf/dompdf'                         => [$docs, $tests, 'www'],
            'imagine/imagine'                       => [$docs, $tests, 'lib/Imagine/Test'],
            'intervention/image'                    => [$docs, $tests, 'public'],
            'jakub-onderka/php-console-color'       => [$docs, $tests, 'build.xml example.php'],
            'jakub-onderka/php-console-highlighter' => [$docs, $tests, 'build.xml'],
            'jeremeamia/SuperClosure'               => [$docs, $tests, 'demo'],
            'laravel/framework'                     => [$docs, $tests, 'build'],
            'leafo/lessphp'                         => [$docs, $tests, 'Makefile package.sh'],
            'maximebf/debugbar'                     => [$docs, $tests, 'demo'],
            'mrclay/minify'                         => [$docs, $tests, 'MIN.txt min_extras min_unit_tests min/builder min/config* min/quick-test* min/utils.php min/groupsConfig.php min/index.php'],
            'mustache/mustache'                     => [$docs, $tests, 'bin'],
            'nikic/php-parser'                      => [$docs, $tests, 'test_old'],
            'phenx/php-font-lib'                    => [$docs, $tests. 'www'],
            'phpoffice/phpexcel'                    => [$docs, $tests, 'Examples unitTests changelog.txt'],
            'phpoffice/phpspreadsheet'              => [$docs, $tests, 'samples'],
            'phpseclib/phpseclib'                   => [$docs, $tests, 'build'],
            'predis/predis'                         => [$docs, $tests, 'bin'],
            'quickbooks/v3-php-sdk'                 => [$docs, $tests, 'docs docs/* src/XSD2PHP/test src/XSD2PHP/test/*'],
            'simplepie/simplepie'                   => [$docs, $tests, 'build compatibility_test ROADMAP.md'],
            'swiftmailer/swiftmailer'               => [$docs, $tests, 'build* notes test-suite create_pear_package.php']
        ];

        if(in_array($packageName, $specials)) {
            return $specials[$packageName];
        }
        return [$docs, $tests];
    }
}
