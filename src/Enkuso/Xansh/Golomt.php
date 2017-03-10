<?php

namespace Enkuso\Xansh;


use Symfony\Component\DomCrawler\Crawler;

class Golomt
{
    const WIDGET_URL = "https://golomtbank.com/en/home/ratesForSites";

    public function xanshTatah($currencies = null)
    {
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, Golomt::WIDGET_URL);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $result = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        $crawler = new Crawler($result);
        $crawler = $crawler->filterXPath('descendant-or-self::body/div/table/tbody');

        $xansh = $crawler->filterXPath('descendant-or-self::tr')->each(function (Crawler $node, $i) {
            $x = $node->filterXPath('descendant-or-self::td')->each(function (Crawler $n, $j) {
                if ($j == 0) {
                    return ['currency' => trim($n->text()),
                        'flag' => 'https://golomtbank.com'.$n->filterXPath('descendant-or-self::p/img')->attr('src')];
                } else {
                    return $n->text();
                }
            });
            return $x;
        });

        $xanshuud = [];
        foreach ($xansh as $item) {
            $x = [
                'currency' => $item[0]['currency'],
                'flag' => $item[0]['flag'],
                'in_cash_buy' => (float)$item[1],
                'in_cash_sell' => (float)$item[2],
                'in_non_cash_buy' => (float)$item[3],
                'in_non_cash_sell' => (float)$item[4],
            ];
            if ($currencies && is_array($currencies) && in_array($item[0]['currency'], $currencies)) $xanshuud[] = $x;
            elseif ($currencies && is_string($currencies) && $item[0]['currency'] == $currencies) return json_encode($x);
            else $xanshuud[] = $x;
        }

        return json_encode($xanshuud);
    }
}