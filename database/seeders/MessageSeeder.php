<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample message 1 - Regular inquiry
        Message::create([
            'name' => 'محمد الهاشمي',
            'email' => 'mohammed@example.com',
            'whatsapp' => '971501234567',
            'subject' => 'استفسار عن خدمات الدهانات',
            'message' => 'السلام عليكم، أرغب في معرفة المزيد عن خدمات الدهانات التي تقدمونها وتكلفتها التقريبية لشقة مكونة من 3 غرف في أبو ظبي. هل تستخدمون دهانات مقاومة للرطوبة؟',
            'is_read' => false,
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
            'is_suspicious' => false,
        ]);

        // Sample message 2 - Service request
        Message::create([
            'name' => 'فاطمة العلي',
            'email' => 'fatima@example.com',
            'whatsapp' => '971512345678',
            'subject' => 'طلب خدمة تركيب جبس بورد',
            'message' => 'مرحباً، أنا مهتمة بتركيب أسقف جبس بورد لشقتي في منطقة العين. هل من الممكن تحديد موعد لمعاينة المكان وتقديم عرض سعر؟ المساحة الإجمالية حوالي 120 متر مربع.',
            'is_read' => true,
            'ip_address' => '192.168.1.101',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Mobile/15E148 Safari/604.1',
            'is_suspicious' => false,
        ]);

        // Sample message 3 - Consultation request
        Message::create([
            'name' => 'خالد النعيمي',
            'email' => 'khalid@example.com',
            'whatsapp' => '971523456789',
            'subject' => 'استشارة بخصوص مشروع تجديد',
            'message' => 'السلام عليكم ورحمة الله، أنا صاحب فيلا في أبو ظبي وأرغب في تجديدها بالكامل. أحتاج إلى استشارة حول أفضل الخيارات للأرضيات والجدران وتوصيات بشأن الديكور الداخلي. هل يمكنكم مساعدتي؟',
            'is_read' => false,
            'ip_address' => '192.168.1.102',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.0 Safari/605.1.15',
            'is_suspicious' => false,
        ]);

        // Sample message 4 - Partnership inquiry
        Message::create([
            'name' => 'سعيد المنصوري',
            'email' => 'saeed@example.com',
            'whatsapp' => '971534567890',
            'subject' => 'فرصة تعاون',
            'message' => 'مرحبًا، أنا مدير مشاريع في شركة تطوير عقاري في الإمارات. نبحث عن شركة صيانة وديكور موثوقة للتعاون في مشاريعنا السكنية الجديدة. نود مناقشة إمكانيات التعاون بيننا لعدة مشاريع في أبو ظبي والعين.',
            'is_read' => false,
            'ip_address' => '192.168.1.103',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36',
            'is_suspicious' => false,
        ]);

        // Sample message 5 - Specific service inquiry
        Message::create([
            'name' => 'مريم الشامسي',
            'email' => 'mariam@example.com',
            'whatsapp' => '971545678901',
            'subject' => 'استفسار عن تركيب الرخام',
            'message' => 'مرحباً، أرغب في تركيب رخام لمدخل منزلي ومغاسل في الحمامات. ما هي أنواع الرخام المتوفرة لديكم والأسعار التقريبية؟ وهل يمكن معاينة عينات من أعمالكم السابقة؟',
            'is_read' => true,
            'ip_address' => '192.168.1.104',
            'user_agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'is_suspicious' => false,
        ]);
    }
}
