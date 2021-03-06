<?php

namespace ArUtil\Tests\Arabic;

use ArUtil\I18N\Arabic;
use ArUtil\I18N\WordTag;
use ArUtil\Tests\AbstractTestCase;

class WordTagTest extends AbstractTestCase
{
    
    /**
     * @var WordTag
     */
    protected $wordTag;
    
    protected function setUp()
    {
        parent::setUp();
        $this->wordTag = new Arabic('WordTag');
    }
    
    /** @test */
    public function it_loads_normalise_class()
    {
        $this->assertInstanceOf(WordTag::class, $this->wordTag->myObject);
    }
    
    /** @test */
    public function it_detect_nouns()
    {
        $this->assertTrue($this->wordTag->isNoun('محمد', 'مع'));
        $this->assertFalse($this->wordTag->isNoun('يذهب', 'و'));
    }
    
    /** @test */
    public function it_tags_text_as_noun_or_not()
    {
        $this->assertEquals(0, $this->wordTag->tagText('يذهب')[0][1]);
        $this->assertEquals(1, $this->wordTag->tagText('المعلم')[0][1]);
        
        $text = 'ذهب الطالب إلى المدرسة';
        $taggedText = $this->wordTag->tagText($text);
        $this->assertCount(4, $taggedText);
        $this->assertEquals(0, $taggedText[0][1]);
        $this->assertEquals(1, $taggedText[1][1]);
        $this->assertEquals(0, $taggedText[2][1]);
        $this->assertEquals(1, $taggedText[3][1]);
    }
    
    /** @test */
    public function it_highlight_text_with_given_class()
    {
        $text = 'ذهب الطالب إلى';
        $higlightedText = $this->wordTag->highlightText($text, 'higlighted');
        
        $this->assertContains('<span class="higlighted">  الطالب</span>', $higlightedText);
    }
    
}
