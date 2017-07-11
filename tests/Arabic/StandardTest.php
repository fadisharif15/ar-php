<?php

namespace Tests\Arabic;

use I18N_Arabic_Standard;
use Tests\AbstractTestCase;

class StandardTest extends AbstractTestCase
{
    
    /**
     * @var I18N_Arabic_Standard
     */
    protected $standard;
    
    protected function setUp()
    {
        parent::setUp();
        $this->standard = new \I18N_Arabic('Standard');
    }
    
    /** @test */
    public function it_loads_normalise_class()
    {
        $this->assertInstanceOf(I18N_Arabic_Standard::class, $this->standard->myObject);
    }
    
    /** @test */
    public function it_fix_arabic_text()
    {
        $text = <<<END
هذا نص عربي ، و فيه علامات ترقيم بحاجة إلى ضبط و معايرة !و كذلك نصوص( بين
أقواس )أو حتى مؤطرة"بإشارات إقتباس "أو- علامات إعتراض -الخ......
<br>
لذا ستكون هذه المكتبة أداة و وسيلة لمعالجة مثل هكذا حالات، بما فيها الواحدات 1
Kg أو مثلا MB 16 وسواها حتى النسب المؤية مثل 20% أو %50 وهكذا ...
END;
        $expectedText = <<<END
هذا نص عربي، وفيه علامات ترقيم بحاجة إلى ضبط ومعايرة! وكذلك نصوص (بين
أقواس) أو حتى مؤطرة "بإشارات إقتباس" أو -علامات إعتراض- الخ...
<br>
لذا ستكون هذه المكتبة أداة و وسيلة لمعالجة مثل هكذا حالات، بما فيها الواحدات 1
Kg أو مثلا <span dir="ltr">16 MB</span> وسواها حتى النسب المؤية مثل %20 أو %50 وهكذا...
END;
        
        $actualText = $this->standard->standard($text);
        
        $this->assertEquals($expectedText, $actualText);
    }
}
