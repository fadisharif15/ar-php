<?php

namespace Tests\Arabic;

use I18N_Arabic_AutoSummarize;
use Tests\AbstractTestCase;

class AutoSummarizeTest extends AbstractTestCase
{
    
    /**
     * @var I18N_Arabic_AutoSummarize
     */
    protected $autoSummarize;
    
    protected function setUp()
    {
        parent::setUp();
        $this->autoSummarize = new \I18N_Arabic('AutoSummarize');
    }
    
    /** @test */
    public function it_loads_salat_class()
    {
        $this->assertInstanceOf(I18N_Arabic_AutoSummarize::class, $this->autoSummarize->myObject);
    }
    
    /** @test */
    public function it_can_read_required_txt_files()
    {
        $this->assertFileIsReadable(
            __DIR__ . '/../../Arabic/data/ar-stopwords.txt',
            "Required file ar-stopwords.txt is missing");
        $this->assertFileIsReadable(
            __DIR__ . '/../../Arabic/data/en-stopwords.txt',
            "Required file en-stopwords.txt is missing");
        $this->assertFileIsReadable(
            __DIR__ . '/../../Arabic/data/important-words.txt',
            "Required file important is missing");
    }
    
    /** @test */
    public function it_can_clean_common_words()
    {
        $text = 'مايو كانون جميع ';
        $expectedText = $this->autoSummarize->cleanCommon($text);
        $this->assertNotContains('جميع', $expectedText);
    }
    
    /** @test */
    public function it_loads_extra_strop_words()
    {
        $this->assertEquals('فبذلك', $this->autoSummarize->cleanCommon('فبذلك'));
        $this->autoSummarize->loadExtra();
        
        $this->assertEquals('', trim($this->autoSummarize->cleanCommon('فبذلك')));
    }
    
    /** @test */
    public function it_extract_keywords_from_a_given_arabic_string()
    {
        $str = file_get_contents(__DIR__ . '/../data/article.txt');
        $extracted_keywords = $this->autoSummarize->getMetaKeywords($str, 3);
        $expected_keywords = "اطفال، اكثر، ضرار";
        
        $this->assertEquals(
            $expected_keywords,
            $extracted_keywords
        );
    }
    
    /** @test */
    public function it_highlight_key_sentences_as_percentage_of_the_input_string()
    {
        $text = <<<END
قال علماء في مركز أبحاث الفيزياء التابع للمنظمة الأوروبية للابحاث النووية يوم الجمعة
أنهم حققوا تصادما بين جسيمات بكثافة قياسية في إنجاز مهم في برنامجهم لكشف أسرار الكون.
وجاء التطور في الساعات الأولى بعد تغذية مصادم الهدرونات الكبير بحزمة أشعة بها
جسيمات أكثر بحوالي ستة في المئة لكل وحدة بالمقارنة مع المستوى القياسي السابق
الذي سجله مصادم تيفاترون التابع لمختبر فرميلاب الأمريكي العام الماضي.
وكل تصادم في النفق الدائري لمصادم الهدرونات البالغ طوله 27 كيلومترا تحت الأرض
بسرعة أقل من سرعة الضوء يحدث محاكاة للانفجار العظيم الذي يفسر به علماء نشوء الكون
قبل 13.7 مليار سنة. وكلما زادت "كثافة الحزمة" أو ارتفع عدد الجسيمات فيها زاد
عدد التصادمات التي تحدث وزادت أيضا المادة التي يكون على العلماء تحليلها.
ويجري فعليا انتاج ملايين كثيرة من هذه "الانفجارات العظيمة المصغرة" يوميا.
وقال رولف هوير المدير العام للمنظمة الاوروبية للأبحاث النووية ومقرها على الحدود
الفرنسية السويسرية قرب جنيف أن "كثافة الحزمة هي الأساس لنجاح مصادم الهدرونات الكبير
ولذا فهذه خطوة مهمة جدا"، وأضاف "الكثافة الأعلى تعني مزيدا من البيانات، ومزيد
من البيانات يعني إمكانية أكبر للكشف." وقال سيرجيو برتولوتشي مدير الأبحاث في المنظمة
"يوجد إحساس ملموس بأننا على أعتاب كشف جديد". وفي حين زاد الفيزيائيون والمهندسون
في المنظمة كثافة حزم الأشعة على مدى الأسبوع المنصرم قال جيمس جيليه المتحدث باسم المنظمة
أنهم جمعوا معلومات تزيد على ما جمعوه على مدى تسعة أشهر من عمل مصادم الهدرونات في 2010.
وتخزن تلك المعلومات على آلاف من أقراص الكمبيوتر. ويمثل المصادم البالغة تكلفته
عشرة مليارات دولار أكبر تجربة علمية منفردة في العالم وقد بدأ تشغيله في نهاية
مارس آذار 2010. وبعد الإغلاق الدائم لمصادم تيفاترون في الخريف القادم سيصبح
مصادم الهدرونات المصادم الكبير الوحيد الموجود في العالم. ومن بين أهداف
مصادم الهدرونات الكبير معرفة ما إذا كان الجسيم البسيط المعروف بإسم جسيم هيجز
أو بوزون هيجز موجود فعليا. ويحمل الجسيم إسم العالم البريطاني بيتر هيجز
الذي كان أول من افترض وجوده كعامل أعطي الكتلة للجسيمات بعد الإنفجار العظيم.
ومن خلال متابعة التصادمات على أجهزة الكمبيوتر في المنظمة الأوروبية للأبحاث النووية
وفي معامل في أنحاء العالم مرتبطة بها يأمل العلماء أيضا أن يجدوا دليلا قويا على
وجود المادة المعتمة التي يعتقد أنها تشكل حوالي ربع الكون المعروف وربما الطاقة المعتمة
التي يعتقد أنها تمثل حوالي 70 في المئة من الكون. ويقول علماء الفلك أن تجارب
المنظمة الأوروبية للأبحاث النووية قد تلقي الضوء أيضا على نظريات جديدة بازغة
تشير إلى أن الكون المعروف هو مجرد جزء من نظام لأكوان كثيرة غير مرئية لبعضها البعض
ولا توجد وسائل للتواصل بينها. ويأملون أيضا أن يقدم مصادم الهدرونات الكبير
الذي سيبقى يعمل على مدى عقد بعد توقف فني لمدة عام في 2013 بعض الدعم
لدلائل يتعقبها باحثون آخرون على أن الكون المعروف سبقه كون آخر قبل الانفجار العظيم.
وبعد التوقف عام 2013 يهدف علماء المنظمة الأوروبية للأبحاث النووية إلى زيادة
الطاقة الكلية لكل تصادم بين الجسيمات من الحد الاقصى الحالي البالغ 7 تيرا الكترون فولت
إلى 14 تيرا الكترون فولت. وسيزيد ذلك أيضا من فرصة التوصل لاكتشافات جديدة فيما تصفه
المنظمة بأنه "الفيزياء الجديدة" بما يدفع المعرفة لتجاوز ما يسمى النموذج المعياري
المعتمد على نظريات العالم البرت اينشتاين في اوائل القرن العشرين.
END;
        $expectedText = <<<END
قال علماء في مركز أبحاث الفيزياء التابع للمنظمة الأوروبية للابحاث النووية يوم الجمعة<br /><span class="summary">أنهم حققوا تصادما بين جسيمات بكثافة قياسية في إنجاز مهم في برنامجهم لكشف أسرار الكون.</span>وجاء التطور في الساعات الأولى بعد تغذية مصادم الهدرونات الكبير بحزمة أشعة بها<br />جسيمات أكثر بحوالي ستة في المئة لكل وحدة بالمقارنة مع المستوى القياسي السابق<br />الذي سجله مصادم تيفاترون التابع لمختبر فرميلاب الأمريكي العام الماضي.وكل تصادم في النفق الدائري لمصادم الهدرونات البالغ طوله 27 كيلومترا تحت الأرض<br />بسرعة أقل من سرعة الضوء يحدث محاكاة للانفجار العظيم الذي يفسر به علماء نشوء الكون<br /> وكلما زادت "كثافة الحزمة" أو ارتفع عدد الجسيمات فيها زاد<br />عدد التصادمات التي تحدث وزادت أيضا المادة التي يكون على العلماء تحليلها.ويجري فعليا انتاج ملايين كثيرة من هذه "الانفجارات العظيمة المصغرة" يوميا.وقال رولف هوير المدير العام للمنظمة الاوروبية للأبحاث النووية ومقرها على الحدود<br />الفرنسية السويسرية قرب جنيف أن "كثافة الحزمة هي الأساس لنجاح مصادم الهدرونات الكبير<br /> وأضاف "الكثافة الأعلى تعني مزيدا من البيانات،" وقال سيرجيو برتولوتشي مدير الأبحاث في المنظمة<br />"يوجد إحساس ملموس بأننا على أعتاب كشف جديد". وفي حين زاد الفيزيائيون والمهندسون<br />في المنظمة كثافة حزم الأشعة على مدى الأسبوع المنصرم قال جيمس جيليه المتحدث باسم المنظمة<br />أنهم جمعوا معلومات تزيد على ما جمعوه على مدى تسعة أشهر من عمل مصادم الهدرونات في 2010.وتخزن تلك المعلومات على آلاف من أقراص الكمبيوتر.عشرة مليارات دولار أكبر تجربة علمية منفردة في العالم وقد بدأ تشغيله في نهاية<br /> وبعد الإغلاق الدائم لمصادم تيفاترون في الخريف القادم سيصبح<br />مصادم الهدرونات المصادم الكبير الوحيد الموجود في العالم.<span class="summary">مصادم الهدرونات الكبير معرفة ما إذا كان الجسيم البسيط المعروف بإسم جسيم هيجز<br /></span><span class="summary">أو بوزون هيجز موجود فعليا.</span><span class="summary"> ويحمل الجسيم إسم العالم البريطاني بيتر هيجز<br /></span>الذي كان أول من افترض وجوده كعامل أعطي الكتلة للجسيمات بعد الإنفجار العظيم.<span class="summary">ومن خلال متابعة التصادمات على أجهزة الكمبيوتر في المنظمة الأوروبية للأبحاث النووية<br /></span><span class="summary">وفي معامل في أنحاء العالم مرتبطة بها يأمل العلماء أيضا أن يجدوا دليلا قويا على<br /></span><span class="summary">وجود المادة المعتمة التي يعتقد أنها تشكل حوالي ربع الكون المعروف وربما الطاقة المعتمة<br /></span>التي يعتقد أنها تمثل حوالي 70 في المئة من الكون. ويقول علماء الفلك أن تجارب<br />المنظمة الأوروبية للأبحاث النووية قد تلقي الضوء أيضا على نظريات جديدة بازغة<br />تشير إلى أن الكون المعروف هو مجرد جزء من نظام لأكوان كثيرة غير مرئية لبعضها البعض<br />ولا توجد وسائل للتواصل بينها.<span class="summary">الذي سيبقى يعمل على مدى عقد بعد توقف فني لمدة عام في 2013 بعض الدعم<br /></span>لدلائل يتعقبها باحثون آخرون على أن الكون المعروف سبقه كون آخر قبل الانفجار العظيم.<span class="summary">وبعد التوقف عام 2013 يهدف علماء المنظمة الأوروبية للأبحاث النووية إلى زيادة<br /></span>الطاقة الكلية لكل تصادم بين الجسيمات من الحد الاقصى الحالي البالغ 7 تيرا الكترون فولت<br />إلى 14 تيرا الكترون فولت. وسيزيد ذلك أيضا من فرصة التوصل لاكتشافات جديدة فيما تصفه<br /><span class="summary">المنظمة بأنه "الفيزياء الجديدة" بما يدفع المعرفة لتجاوز ما يسمى النموذج المعياري<br /></span>المعتمد على نظريات العالم البرت اينشتاين في اوائل القرن العشرين.
END;
        
        $actualText = $this->autoSummarize->highlightRateSummary($text, 25, 'هيجنز', 'summary');
        
        $this->assertEquals($expectedText, $actualText);
    }
}
