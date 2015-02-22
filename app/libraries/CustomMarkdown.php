<?php

class CustomMarkdown extends \cebe\markdown\GithubMarkdown
{
	/**
	 * Parses an image indicated by `![`.
	 * @marker ![
	 */
    // @Override
	protected function parseImage($markdown)
	{
		if (($parts = $this->parseLinkOrImage(substr($markdown, 1))) !== false) {
			list($text, $url, $title, $offset, $key, $height, $width) = $parts;

			return [
				[
					'image',
					'text' => $text,
					'url' => $url,
					'title' => $title,
					'refkey' => $key,
					'height' => $height,
					'width' => $width,
					'orig' => substr($markdown, 0, $offset + 1),
				],
				$offset + 1
			];
		} else {
			// remove all starting [ markers to avoid next one to be parsed as link
			$result = '!';
			$i = 1;
			while (isset($markdown[$i]) && $markdown[$i] == '[') {
				$result .= '[';
				$i++;
			}
			return [['text', $result], $i];
		}
	}

    // @Override
	protected function exParseLinkOrImage($markdown)
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

    // @Override
	protected function parseLinkOrImage($markdown)
	{
		if (strpos($markdown, ']') !== false && preg_match('/\[((?>[^\]\[]+|(?R))*)\]/', $markdown, $textMatches)) { // TODO improve bracket regex
			$text = $textMatches[1];
			$offset = strlen($textMatches[0]);
			$markdown = substr($markdown, $offset);

			$pattern = <<<REGEXP
				/(?(R) # in case of recursion match parentheses
					 \(((?>[^\s()]+)|(?R))*\)
				|      # else match a link with title
					^\((((?>[^\s()]+)|(?R))*)(\s+"(.*?)")?\)?(\s+=([0-9]+)?x([0-9]+)?)?\)
				)/x
REGEXP;
			if (preg_match($pattern, $markdown, $refMatches)) {
				// inline link
				return [
					$text,
					isset($refMatches[2]) ? $refMatches[2] : '', // url
					empty($refMatches[5]) ? null: $refMatches[5], // title
					$offset + strlen($refMatches[0]), // offset
					null, // reference key
					isset($refMatches[7]) ? $refMatches[7] : null,//height
					isset($refMatches[8]) ? $refMatches[8] : null //width
				];
			} elseif (preg_match('/^([ \n]?\[(.*?)\])?/s', $markdown, $refMatches)) {
				// reference style link
				if (empty($refMatches[2])) {
					$key = strtolower($text);
				} else {
					$key = strtolower($refMatches[2]);
				}
				return [
					$text,
					null, // url
					null, // title
					$offset + strlen($refMatches[0]), // offset
					$key,
					null,
					null
				];
			}
		}
		return false;
	}

    // @Override
	protected function renderImage($block)
	{
		if (isset($block['refkey'])) {
			if (($ref = $this->lookupReference($block['refkey'])) !== false) {
				$block = array_merge($block, $ref);
			} else {
				return $block['orig'];
			}
		}
		return '<img src="' . htmlspecialchars($block['url'], ENT_COMPAT | ENT_HTML401, 'UTF-8') . '"'
			. ' alt="' . htmlspecialchars($block['text'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"'
			. (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
			. (empty($block['height']) ? '' : ' height="' . htmlspecialchars($block['height'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
			. (empty($block['width'])  ? '' : ' width="'  . htmlspecialchars($block['width'],  ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
			. ($this->html5 ? '>' : ' />');
	}

}
