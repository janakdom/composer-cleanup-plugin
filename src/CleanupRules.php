<?php
namespace Janakdom\Composer;

class CleanupRules
{
    const _docs = 'README* CHANGELOG* FAQ* CONTRIBUTING* Changelog* HISTORY* UPGRADING* UPGRADE* COPYRIGHT* package* demo example examples doc docs readme* changelog* composer*';
    const _tests = '.travis.yml .scrutinizer.yml phpcs.xml* phpcs.php phpunit.xml* phpunit.php test tests Tests travis patchwork.json';
    const _others = 'LICENSE* .php-cs-fixer.dist.php appveyor.yml Makefile .github .gitattributes .coveralls.yml .editorconfig .install .gitmodules .gitignore SECURITY* phpstan.neon* .doctrine-project.json psalm.xml* humbug.json* phpstan-baseline* psalm-baseline*';

    public static function getRules($packageName)
    {
        if($packageName == "composer") {
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
            'doctrine/deprecations'                 => 'test_fixtures',
            'doctrine/dbal'                         => 'bin build* docs2 lib/vendor static-analysis',
            'doctrine/doctrine-bundle'              => '.symfony.bundle.yaml',
            'doctrine/doctrine-fixtures-bundle'     => '.symfony.bundle.yaml',
            'doctrine/doctrine-migrations-bundle'   => '.symfony.bundle.yaml',
            'doctrine/instantiator'                 => 'phpbench.json',
            'doctrine/migrations'                   => 'bin build-phar.sh download-box.sh phpstan-common.neon* phpstan-dbal-2* phpstan-dbal-3*',
            'doctrine/orm'                          => 'bin ci phpstan-dbal2.neon phpstan-params.neon doctrine-mapping.xsd',
            'doctrine/sql-formatter'                => 'bin',
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
            'nikic/php-parser'                      => 'test_old bin grammar',
            'phenx/php-font-lib'                    => 'www',
            'phpoffice/phpexcel'                    => 'Examples unitTests changelog.txt',
            'phpoffice/phpspreadsheet'              => 'samples',
            'phpseclib/phpseclib'                   => 'build',
            'predis/predis'                         => 'bin',
            'quickbooks/v3-php-sdk'                 => 'docs docs/* src/XSD2PHP/test src/XSD2PHP/test/*',
            'simplepie/simplepie'                   => 'build compatibility_test ROADMAP.md',
            'swiftmailer/swiftmailer'               => 'build* notes test-suite create_pear_package.php',
            'friendsofphp/php-cs-fixer'             => 'ci-integration.sh logo.md logo.png php-cs-fixer',
            'gedmo/doctrine-extensions'             => 'doctrine-mapping.xsd .yamllint schemas',
            'paragonie/random_compat'               => 'build-phar.sh dist',
            'paragonie/sodium_compat'               => 'dist build-phar.sh appveyor.yml psalm-above-3.xml psalm-below-3.xml',
            'phpstan/phpstan'                       => 'phpstan.phar.asc conf',
            'ramsey/collection'                     => 'bin',
            'symplify/easy-coding-standard'         => 'bin',
            'sensio/framework-extra-bundle'         => '.php_cs* .symfony.bundle.yaml',
            'spomky-labs/otphp'                     => 'CODE_OF_CONDUCT* .php_cs.dist',
        ];


        $out = [self::_docs, self::_tests, self::_others];
        if(array_key_exists($packageName, $specials)) {
            $out[] = $specials[$packageName];
        }
        
        if($packageName == 'symplify/easy-coding-standard') {
            $out[0] = str_replace('package* ', '', $out[0]);
        }
        
        return $out;
    }
}
