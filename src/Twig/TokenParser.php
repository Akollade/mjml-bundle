<?php

namespace NotFloran\MjmlBundle\Twig;

use Twig\TokenParser\AbstractTokenParser;
use Twig\Token;

class TokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $line = $token->getLine();

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse(function (Token $token) {
            return $token->test('endmjml');
        }, true);

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new Node($body, $line, $this->getTag());
    }

    /**
     * Return the name of the twig tag.
     *
     * @return string
     */
    public function getTag()
    {
        return 'mjml';
    }
}
