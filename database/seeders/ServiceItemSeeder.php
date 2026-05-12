<?php

namespace Database\Seeders;

use App\Models\ServiceItem;
use App\Models\ServiceSection;
use Illuminate\Database\Seeder;

class ServiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the service section ID (or use 1 if none exists)
        $serviceSectionId = ServiceSection::first()?->id ?? 1;

        $services = [
            [
                'icon' => 'bi bi-grid',
                'title' => 'تركيب سيراميك',
                'short_description' => 'خدمات احترافية لتركيب جميع أنواع السيراميك',
                'description' => 'نقدم في نور الوجود خدمات تركيب السيراميك بأعلى مستويات الاحترافية والدقة. فريق العمل لدينا متخصص في تركيب جميع أنواع السيراميك للأرضيات والجدران بتقنيات متطورة تضمن النتائج المثالية والمتانة. نستخدم أفضل المواد والأدوات للحصول على تشطيبات عالية الجودة تدوم لسنوات طويلة.',
                'image' => 'assets-home/img/services/ceramic-tiles.jpg',
                'is_active' => true,
                'ordering' => 1,
            ],
            [
                'icon' => 'bi bi-grid-3x3',
                'title' => 'تركيب بلاط',
                'short_description' => 'تركيب بلاط أرضيات وجدران بتقنيات حديثة',
                'description' => 'خدمات تركيب البلاط لدينا تشمل جميع أنواع البلاط المصنوع من البورسلين، الرخام، الجرانيت وغيرها من المواد. نقدم حلول متكاملة من اختيار النوع المناسب حتى التركيب النهائي مع الالتزام بأعلى معايير الجودة والدقة في جميع مراحل العمل.',
                'image' => 'assets-home/img/services/floor-tiles.jpg',
                'is_active' => true,
                'ordering' => 2,
            ],
            [
                'icon' => 'bi bi-brush',
                'title' => 'صباغة',
                'short_description' => 'خدمات دهان احترافية للمنازل والمكاتب',
                'description' => 'نوفر خدمات الصباغة الداخلية والخارجية للمباني السكنية والتجارية بأحدث التقنيات وأفضل أنواع الدهانات. يضمن فريقنا المحترف تنفيذ الأعمال بجودة عالية ودقة متناهية. نستخدم دهانات صديقة للبيئة وذات جودة عالية تدوم طويلاً وتحافظ على رونقها لسنوات.',
                'image' => 'assets-home/img/services/painting.jpg',
                'is_active' => true,
                'ordering' => 3,
            ],
            [
                'icon' => 'bi bi-layers',
                'title' => 'بديل رخام وخشب',
                'short_description' => 'حلول بديلة للرخام والخشب بجودة عالية وتكلفة مناسبة',
                'description' => 'نقدم خدمات تركيب بدائل الرخام والخشب عالية الجودة التي توفر مظهراً فاخراً بتكلفة أقل من المواد الأصلية. تتميز هذه البدائل بسهولة التركيب والصيانة، ومقاومة الرطوبة والخدوش، مع الحفاظ على المظهر الجمالي المميز للرخام والخشب الطبيعي.',
                'image' => 'assets-home/img/services/marble-wood-alternative.jpg',
                'is_active' => true,
                'ordering' => 4,
            ],
            [
                'icon' => 'bi bi-droplet',
                'title' => 'سباكة',
                'short_description' => 'خدمات سباكة متكاملة للمنازل والمنشآت التجارية',
                'description' => 'نقدم خدمات السباكة الشاملة بما في ذلك التركيب والإصلاح والصيانة لجميع أنظمة المياه والصرف الصحي. فريقنا من السباكين المحترفين يقدم حلولاً عملية وفعالة لجميع مشاكل السباكة باستخدام أحدث التقنيات والمعدات لضمان خدمة سريعة وموثوقة.',
                'image' => 'assets-home/img/services/plumbing.jpg',
                'is_active' => true,
                'ordering' => 5,
            ],
            [
                'icon' => 'bi bi-columns',
                'title' => 'جبس بورد',
                'short_description' => 'تصميم وتركيب أعمال الجبس بورد بأشكال عصرية',
                'description' => 'نتخصص في تصميم وتركيب أسقف وقواطع الجبس بورد بأحدث التصاميم العصرية. خدماتنا تشمل تنفيذ الديكورات الداخلية، والأسقف المعلقة، وإخفاء الخدمات، وأعمال الإضاءة المخفية. نستخدم مواد عالية الجودة مقاومة للرطوبة والحريق لضمان السلامة والمتانة.',
                'image' => 'assets-home/img/services/gypsum-board.jpg',
                'is_active' => true,
                'ordering' => 6,
            ],
            [
                'icon' => 'bi bi-grid-1x2',
                'title' => 'فورسيلنج',
                'short_description' => 'أسقف مستعارة بتصاميم حديثة وجودة عالية',
                'description' => 'خدمات تركيب الأسقف المستعارة (فورسيلنج) بأحدث التصاميم والمواد عالية الجودة. تعتبر الأسقف المستعارة حلاً مثالياً لإخفاء التمديدات الكهربائية والتكييف مع إضافة لمسة جمالية للمكان. نوفر مجموعة متنوعة من الخيارات لتناسب جميع الأذواق والميزانيات.',
                'image' => 'assets-home/img/services/false-ceiling.jpg',
                'is_active' => true,
                'ordering' => 7,
            ],
            [
                'icon' => 'bi bi-diamond',
                'title' => 'تجارة وتركيب رخام',
                'short_description' => 'توريد وتركيب أجود أنواع الرخام المحلي والمستورد',
                'description' => 'نوفر خدمات توريد وتركيب الرخام الطبيعي بأنواعه المختلفة للأرضيات والجدران والواجهات والمطابخ. لدينا تشكيلة واسعة من أرقى أنواع الرخام المحلي والمستورد بألوان وتصاميم متنوعة. يقوم فريقنا المتخصص بتنفيذ أعمال التركيب بدقة عالية وحرفية متميزة.',
                'image' => 'assets-home/img/services/marble.jpg',
                'is_active' => true,
                'ordering' => 8,
            ],
            [
                'icon' => 'bi bi-droplet-half',
                'title' => 'مغاسل رخام',
                'short_description' => 'تصميم وتنفيذ مغاسل رخام فاخرة للحمامات والمطابخ',
                'description' => 'نتخصص في تصميم وتركيب مغاسل الرخام الفاخرة للحمامات والمطابخ بأحدث التصاميم العصرية. نستخدم أفخم أنواع الرخام الطبيعي لتنفيذ مغاسل تجمع بين الأناقة والعملية. تتميز مغاسلنا الرخامية بالمتانة وسهولة التنظيف والمظهر الفخم الذي يضيف قيمة جمالية للمكان.',
                'image' => 'assets-home/img/services/marble-sinks.jpg',
                'is_active' => true,
                'ordering' => 9,
            ],
            [
                'icon' => 'bi bi-tools',
                'title' => 'حداد واعمال حدادة',
                'short_description' => 'أعمال الحدادة المتنوعة للمنازل والمنشآت التجارية',
                'description' => 'نقدم خدمات الحدادة الشاملة بما في ذلك تصنيع وتركيب الأبواب الحديدية، الشبابيك، الدرابزينات، البوابات، الهياكل المعدنية وغيرها. يعمل فريقنا من الحدادين المهرة على تنفيذ جميع الأعمال بدقة واحترافية باستخدام أجود أنواع المعادن وأحدث تقنيات اللحام والتشكيل.',
                'image' => 'assets-home/img/services/metal-work.jpg',
                'is_active' => true,
                'ordering' => 10,
            ],
        ];

        foreach ($services as $service) {
            ServiceItem::create([
                'service_section_id' => $serviceSectionId,
                'icon' => $service['icon'],
                'title' => $service['title'],
                'short_description' => $service['short_description'],
                'description' => $service['description'],
                'image' => $service['image'],
                'is_active' => $service['is_active'],
                'ordering' => $service['ordering'],
            ]);
        }
    }
}
