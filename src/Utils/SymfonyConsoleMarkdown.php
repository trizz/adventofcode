<?php

declare(strict_types=1);

namespace AdventOfCode21\Utils;

use cebe\markdown\GithubMarkdown;
use function explode;
use function implode;
use JetBrains\PhpStorm\Pure;
use function ltrim;
use function sprintf;
use function str_repeat;
use function str_replace;
use function substr;
use function trim;

/**
 * Based on: https://github.com/phppkg/cli-markdown/blob/f9fbfd50cc09ff8904ea2bb47660b93036235b6d/src/CliMarkdown.php.
 *
 * @todo improve all the things and fix Psalm errors.
 */
class SymfonyConsoleMarkdown extends GithubMarkdown
{
    public const NL = "\n";

    public const NL2 = "\n\n";

    #[Pure]
    public function wrapColor(string $text, string $fg = null, string $bg = null, string $options = null): string
    {
        $values = urldecode(http_build_query(compact('fg', 'bg', 'options'), arg_separator: ';'));

        if (empty($values)) {
            return $text;
        }

        return sprintf('<%s>%s</>', $values, $text);
    }

    public function render(string $text): string
    {
        return $this->parse($text);
    }

    public function parse($text): string
    {
        $parsed = parent::parse($text);

        return str_replace(["\n\n\n", "\n\n\n\n"], "\n\n", ltrim($parsed));
    }

    protected function renderHeadline($block): string
    {
        $level = (int) $block['level'];

        $prefix = str_repeat('#', $level);
        $title = $this->renderAbsy($block['content']);

        $hlText = $prefix.' '.$title;

        return self::NL.$this->wrapColor($hlText, fg: 'yellow', options: 'bold').self::NL2;
    }

    protected function renderParagraph($block): string
    {
        return self::NL.$this->renderAbsy($block['content']).self::NL;
    }

    protected function renderList($block): string
    {
        $output = self::NL;

        foreach ($block['items'] as $itemLines) {
            $output .= '● '.$this->renderAbsy($itemLines)."\n";
        }

        return $output.self::NL2;
    }

    protected function renderTable($block): string
    {
        $head = $body = '';
        // $cols = $block['cols'];

        $tabInfo = ['width' => 60];
        $colWidths = [];
        foreach ($block['rows'] as $row) {
            foreach ($row as $c => $cell) {
                $cellLen = $this->getCellWith($cell);

                if (!isset($tabInfo[$c])) {
                    $colWidths[$c] = 16;
                }

                $colWidths[$c] = $this->compareMax($cellLen, $colWidths[$c]);
            }
        }

        $colCount = count($colWidths);
        $tabWidth = array_sum($colWidths);

        $first = true;
        $splits = [];
        foreach ($block['rows'] as $row) {
            // $cellTag = $first ? 'th' : 'td';
            $tds = [];
            foreach ($row as $c => $cell) {
                $cellLen = $colWidths[$c];

                // ︱｜｜—―￣==＝＝▪▪▭▭▃▃▄▄▁▁▕▏▎┇╇══
                if ($first) {
                    $splits[] = str_pad('=', $cellLen + 1, '=');
                }

                $lastIdx = count($cell) - 1;
                // padding space to last item contents.
                foreach ($cell as $idx => &$item) {
                    if ($lastIdx === $idx) {
                        $item[1] = str_pad($item[1], $cellLen);
                    } else {
                        $cellLen -= mb_strlen($item[1]);
                    }
                }
                unset($item);

                $tds[] = trim($this->renderAbsy($cell), "\n\r");
            }

            $tdsStr = implode(' | ', $tds);
            if ($first) {
                $head .= sprintf("%s\n%s\n%s\n", implode('=', $splits), $tdsStr, implode('|', $splits));
            } else {
                $body .= $tdsStr."\n";
            }
            $first = false;
        }

        // return $this->composeTable($head, $body);
        return $head.$body.str_pad('=', $tabWidth + $colCount + 1, '=').self::NL;
    }

    protected function getCellWith(array $cellElems): int
    {
        $width = 0;
        foreach ($cellElems as $elem) {
            $width += mb_strlen($elem[1] ?? '');
        }

        return $width;
    }

    protected function renderLink($block): string
    {
        preg_match('/(\[.*])(\(.*\))/', $block['orig'], $matches);

        [, $title, $link] = $matches;

        $title = substr($title, 1, -1);
        $link = substr($link, 1, -1);

        $value = $link === $title ? $link : sprintf('[%s](%s)', $title, $link);

        return $this->wrapColor($value, fg: 'bright-blue');
    }

    #[Pure]
    protected function renderAutoUrl($block): string
    {
        return $this->wrapColor($block[1], fg: 'bright-blue');
    }

    #[Pure]
    protected function renderImage($block): string
    {
        return self::NL.$this->wrapColor('▨ '.$block['orig'], fg: 'blue');
    }

    protected function renderQuote($block): string
    {
        // ¶ §
        $content = ltrim($this->renderAbsy($block['content']));

        return self::NL.'¶ '.$this->wrapColor($content, fg: 'green', options: 'bold');
    }

    #[Pure]
    protected function renderCode($block): string
    {
        $lines = explode(self::NL, $block['content']);
        $text = implode("\n    ", $lines);

        return "\n    ".$this->wrapColor($text, fg: 'gray').self::NL2;
    }

    #[Pure]
    protected function renderInlineCode($block): string
    {
        return $this->wrapColor($block[1], fg: 'bright-red');
    }

    protected function renderStrong($block): string
    {
        $text = $this->renderAbsy($block[1]);

        return $this->wrapColor(sprintf('**%s**', $text), options: 'bold');
    }

    protected function renderEmph($block): string
    {
        $text = $this->renderAbsy($block[1]);

        return $this->wrapColor(sprintf('_%s_', $text), fg: 'bright-white');
    }

    /**
     * @psalm-suppress ParamNameMismatch Mismatch is caused by a package.
     *
     * @param mixed $block
     */
    protected function renderText($block): string
    {
        return $block[1];
    }

    private function compareMax(int $len1, int $len2): int
    {
        return $len1 > $len2 ? $len1 : $len2;
    }
}
