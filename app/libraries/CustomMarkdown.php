<?php

class CustomMarkdown extends \cebe\markdown\GithubMarkdown
{
	/**
	 * Renders a code block
	 */
    //@Override
	protected function renderCode($block)
	{
		$class = isset($block['language']) ? ' class="language-' . $block['language'] . '"' : '';
		return "<pre><code$class>" . implode("\n", $block['content']) . "\n" . '</code></pre>';
	}
}
