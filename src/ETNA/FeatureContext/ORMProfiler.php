<?php

namespace ETNA\FeatureContext;

trait ORMProfiler
{
    static private $currentQuery =  0;
    static private $max_queries  = 10;

    /**
     * @BeforeScenario
     */
    public function resetProfiler()
    {
        self::$currentQuery += self::$silex_app["orm.profiler"]->currentQuery;
        self::$silex_app["orm.profiler"]->queries      = [];
        self::$silex_app["orm.profiler"]->currentQuery = 0;
        self::$max_queries = 10;
        if (isset(self::$_parameters['maxQueries']) && self::$_parameters['maxQueries']) {
            self::$max_queries = self::$_parameters['maxQueries'];
        }
    }

    /**
     * @AfterSuite
     */
    public static function showQueryCount()
    {
        echo "\n# total queries : ", self::$currentQuery, "\n";
    }

    /**
     * @Given /^que j\'ai le droit de faire (\d+) requetes SQL$/
     */
    public function queJAiLeDroitDeFaireRequetesSql($nb)
    {
        self::$max_queries = $nb;
    }
}
