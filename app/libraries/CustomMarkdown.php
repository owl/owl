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

    //@Override
	protected function parseImage($markdown){
		if (($parts = $this->parseLinkOrImage(substr($markdown, 1))) !== false) {
			list($text, $url, $title, $offset, $height, $width) = $parts;

			$image = '<img src="' . htmlspecialchars($url, ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
				. ' alt="' . htmlspecialchars($text, ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
				. (empty($title)  ? '' : ' title="'  . htmlspecialchars($title,  ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"')
				. (empty($height) ? '' : ' height="' . htmlspecialchars($height, ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"')
				. (empty($width)  ? '' : ' width="'  . htmlspecialchars($width,  ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"')
				. ($this->html5 ? '>' : ' />');

			return [$image, $offset + 1];
		} else {
			// remove all starting [ markers to avoid next one to be parsed as link
			$result = '!';
			$i = 1;
			while(isset($markdown[$i]) && $markdown[$i] == '[') {
				$result .= '[';
				$i++;
			}
			return [$result, $i];
		}
	}

	private function parseLinkOrImage($markdown)
	{
		if (strpos($markdown, ']') !== false && preg_match('/\[((?:[^][]|(?R))*)\]/', $markdown, $textMatches)) { // TODO improve bracket regex
			$text = $textMatches[1];
			$offset = strlen($textMatches[0]);
			$markdown = substr($markdown, $offset);

			if (preg_match('/^\(([^\s]*?)(\s+"(.*?)")?(\s+=([0-9]+)?x([0-9]+)?)?\)/', $markdown, $refMatches)) {
				// inline link
				return [
					$text,
					$refMatches[1], // url
					empty($refMatches[3]) ? null: $refMatches[3], // title
					$offset + strlen($refMatches[0]), // offset
					isset($refMatches[5]) ? $refMatches[5] : null,//height
					isset($refMatches[6]) ? $refMatches[6] : null //width
				];
			} elseif (preg_match('/^[ \n]?\[(.*?)\]/', $markdown, $refMatches)) {
				// reference style link
				if (empty($refMatches[1])) {
					$key = strtolower($text);
				} else {
					$key = strtolower($refMatches[1]);
				}
				if (isset($this->references[$key])) {
					return [
						$text,
						$this->references[$key]['url'], // url
						empty($this->references[$key]['title']) ? null: $this->references[$key]['title'], // title
						$offset + strlen($refMatches[0]), // offset
					];
				}
			}
		}
		return false;
	}
}
