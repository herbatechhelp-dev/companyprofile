<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\CompanyInfo;
use App\Models\ContactMessage;
use App\Models\HomeSection;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data first
        $this->clearExistingData();

        // Site Settings
        $this->createSiteSettings();

        // Admin Users
        $this->createAdminUsers();

        // Home Sections
        $this->createHomeSections();

        // Company Info
        $this->createCompanyInfo();

        // Products
        $this->createProducts();

        // Articles
        $this->createArticles();

        // Contact Messages
        $this->createContactMessages();
    }

    private function clearExistingData(): void
    {
        // Comment these lines if you don't want to clear existing data
        // Article::truncate();
        // CompanyInfo::truncate();
        // ContactMessage::truncate();
        // HomeSection::truncate();
        // Product::truncate();
        // SiteSetting::truncate();
    }

    private function createSiteSettings(): void
    {
        $settings = [
            [
                'key' => 'company_name',
                'value' => 'GreenTech Solutions',
                'type' => 'text'
            ],
            [
                'key' => 'tagline',
                'value' => 'Innovating for a Sustainable Future',
                'type' => 'text'
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Sustainable Development No. 123, Jakarta, Indonesia',
                'type' => 'text'
            ],
            [
                'key' => 'phone',
                'value' => '+62 21 1234 5678',
                'type' => 'text'
            ],
            [
                'key' => 'email',
                'value' => 'info@greentech.com',
                'type' => 'text'
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/greentech',
                'type' => 'text'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/greentech',
                'type' => 'text'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/greentech',
                'type' => 'text'
            ],
            [
                'key' => 'footer_description',
                'value' => 'Leading the way in sustainable technology and environmental solutions for a better tomorrow.',
                'type' => 'text'
            ]
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    private function createAdminUsers(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@herbatech.tech',
                'password' => 'Admin@12345',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }

    private function createHomeSections(): void
    {
        $sections = [
            [
                'section' => 'hero',
                'title' => 'GreenTech Solutions',
                'content' => 'Leading the way in sustainable technology and environmental solutions for a better tomorrow.',
                'is_active' => true
            ],
            [
                'section' => 'about',
                'title' => 'About GreenTech Solutions',
                'content' => '<p>Founded in 2010, GreenTech Solutions has been at the forefront of sustainable technology innovation. Our mission is to develop cutting-edge solutions that address environmental challenges while driving economic growth.</p><p>With over a decade of experience, we have successfully implemented projects across various industries, helping businesses reduce their environmental footprint while improving efficiency and profitability.</p>',
                'is_active' => true
            ],
            [
                'section' => 'products',
                'title' => 'Our Sustainable Products',
                'content' => 'Discover our innovative product portfolio designed to promote sustainability and environmental conservation.',
                'is_active' => true
            ],
            [
                'section' => 'research',
                'title' => 'Research & Development',
                'content' => 'Stay updated with our latest research breakthroughs and technological innovations.',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_active' => true
            ]
        ];

        foreach ($sections as $section) {
            HomeSection::updateOrCreate(
                ['section' => $section['section']],
                $section
            );
        }
    }

    private function createCompanyInfo(): void
    {
        $companyPages = [
            [
                'page' => 'our-group',
                'title' => 'Our Group Structure',
                'description' => '<p>GreenTech Solutions operates through three main divisions, each focusing on different aspects of sustainable technology:</p><ul><li><strong>Renewable Energy Division</strong>: Specializing in solar, wind, and hydro power solutions</li><li><strong>Environmental Consulting</strong>: Providing expert advice on sustainability practices</li><li><strong>Green Technology R&D</strong>: Driving innovation in eco-friendly technologies</li></ul>',
                'icons' => json_encode([
                    ['title' => 'Global Presence', 'icon' => 'heroicon-o-globe', 'description' => 'Operating in 15+ countries worldwide'],
                    ['title' => 'Expert Team', 'icon' => 'heroicon-o-users', 'description' => '150+ dedicated professionals'],
                    ['title' => 'Projects Completed', 'icon' => 'heroicon-o-check-badge', 'description' => '500+ successful projects']
                ])
            ],
            [
                'page' => 'sustainability',
                'title' => 'Sustainability & Future Insight',
                'description' => '<p>At GreenTech Solutions, sustainability is at the core of everything we do. Our commitment extends beyond business to creating a positive impact on society and the environment.</p><p>We envision a future where technology and nature coexist harmoniously, and we are dedicated to making this vision a reality through our innovative solutions and responsible business practices.</p>',
                'icons' => json_encode([
                    ['title' => 'Carbon Neutral', 'icon' => 'heroicon-o-leaf', 'description' => 'Committed to carbon neutrality by 2025'],
                    ['title' => 'Circular Economy', 'icon' => 'heroicon-o-arrow-path', 'description' => 'Promoting circular economy principles'],
                    ['title' => 'Community Development', 'icon' => 'heroicon-o-heart', 'description' => 'Investing in local communities']
                ])
            ],
            [
                'page' => 'legal',
                'title' => 'Legal & Compliance',
                'description' => '<p>GreenTech Solutions operates with the highest standards of legal compliance and corporate governance. We are committed to transparency, ethical business practices, and regulatory compliance in all our operations.</p><p>Our legal framework ensures that we meet all environmental regulations, labor laws, and business compliance requirements in every market we operate.</p>',
                'icons' => json_encode([
                    ['title' => 'ISO Certified', 'icon' => 'heroicon-o-shield-check', 'description' => 'ISO 14001:2015 Environmental Management'],
                    ['title' => 'Legal Compliance', 'icon' => 'heroicon-o-document-check', 'description' => '100% regulatory compliance'],
                    ['title' => 'Ethical Practices', 'icon' => 'heroicon-o-scale', 'description' => 'Adherence to ethical business standards']
                ])
            ]
        ];

        foreach ($companyPages as $page) {
            CompanyInfo::updateOrCreate(
                ['page' => $page['page']],
                $page
            );
        }
    }

    private function createProducts(): void
    {
        $products = [
            [
                'name' => 'Solar Panel System',
                'category' => 'Renewable Energy',
                'description' => '<p>High-efficiency solar panel systems for residential and commercial use. Our systems feature advanced photovoltaic technology with efficiency rates up to 22%.</p><ul><li>25-year performance warranty</li><li>Smart monitoring system</li><li>Easy installation process</li></ul>',
                'is_featured' => true,
                'order' => 1
            ],
            [
                'name' => 'Wind Turbine Generator',
                'category' => 'Renewable Energy',
                'description' => '<p>Compact and efficient wind turbine generators suitable for urban and rural environments. Designed for low noise operation and maximum energy capture.</p><ul><li>Low maintenance design</li><li>Weather resistant</li><li>Scalable solutions</li></ul>',
                'is_featured' => true,
                'order' => 2
            ],
            [
                'name' => 'Water Purification System',
                'category' => 'Environmental Technology',
                'description' => '<p>Advanced water purification systems using reverse osmosis and UV sterilization technology. Provides clean drinking water while reducing plastic bottle waste.</p><ul><li>Multi-stage filtration</li><li>Energy efficient</li><li>Easy maintenance</li></ul>',
                'is_featured' => true,
                'order' => 3
            ],
            [
                'name' => 'Energy Storage Solution',
                'category' => 'Renewable Energy',
                'description' => '<p>Advanced lithium-ion battery systems for energy storage and management. Perfect for solar and wind energy applications.</p><ul><li>Long lifespan</li><li>Smart energy management</li><li>Scalable capacity</li></ul>',
                'is_featured' => false,
                'order' => 4
            ],
            [
                'name' => 'Smart Grid Technology',
                'category' => 'Energy Management',
                'description' => '<p>Intelligent grid management systems that optimize energy distribution and reduce waste through AI-powered analytics.</p><ul><li>Real-time monitoring</li><li>Predictive maintenance</li><li>Energy optimization</li></ul>',
                'is_featured' => false,
                'order' => 5
            ],
            [
                'name' => 'Eco-Friendly Building Materials',
                'category' => 'Sustainable Construction',
                'description' => '<p>Innovative building materials made from recycled and sustainable sources. Reduce carbon footprint while maintaining structural integrity.</p><ul><li>Carbon negative</li><li>High durability</li><li>Cost effective</li></ul>',
                'is_featured' => true,
                'order' => 6
            ]
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }

    private function createArticles(): void
    {
        // Ensure categories exist
        $csrCategory = ArticleCategory::firstOrCreate(['slug' => 'csr'], ['name' => 'CSR']);
        $eventsCategory = ArticleCategory::firstOrCreate(['slug' => 'events'], ['name' => 'Events']);

        $articles = [
            [
                'title' => 'Community Tree Planting Initiative 2024',
                'slug' => 'community-tree-planting-initiative-2024',
                'article_category_id' => $csrCategory->id,
                'content' => '<p>GreenTech Solutions successfully organized a community tree planting event in collaboration with local environmental groups. Over 500 volunteers participated in planting 2,000 native tree species in the urban forest area.</p>
                            <p>The initiative aims to combat urban heat island effect and improve air quality in the city. We are committed to planting 10,000 trees by 2025 as part of our environmental commitment.</p>
                            <h3>Event Highlights</h3>
                            <ul>
                                <li>2,000 trees planted in urban areas</li>
                                <li>500+ community volunteers</li>
                                <li>15 corporate partners</li>
                                <li>5 hectares of green space created</li>
                            </ul>',
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'Annual Sustainability Conference 2024',
                'slug' => 'annual-sustainability-conference-2024',
                'article_category_id' => $eventsCategory->id,
                'content' => '<p>Join us for our Annual Sustainability Conference where industry leaders share insights on green technology and sustainable business practices.</p>
                            <h3>Conference Details</h3>
                            <p><strong>Date:</strong> November 15-16, 2024<br>
                            <strong>Location:</strong> Jakarta Convention Center<br>
                            <strong>Theme:</strong> "Innovating for a Greener Future"</p>
                            <h3>Featured Speakers</h3>
                            <ul>
                                <li>Dr. Sarah Johnson - Climate Change Expert</li>
                                <li>Michael Chen - Renewable Energy Pioneer</li>
                                <li>Maria Rodriguez - Sustainable Business Leader</li>
                            </ul>',
                'published_at' => now()->addDays(10)
            ],
            [
                'title' => 'Employee Volunteer Program Launch',
                'slug' => 'employee-volunteer-program-launch',
                'article_category_id' => $csrCategory->id,
                'content' => '<p>We are excited to announce the launch of our new Employee Volunteer Program, allowing our team members to contribute 40 paid hours annually to environmental and social causes.</p>
                            <p>The program has already seen tremendous participation with over 200 employees signing up in the first week.</p>
                            <h3>Program Benefits</h3>
                            <ul>
                                <li>40 paid volunteer hours per year</li>
                                <li>Team building opportunities</li>
                                <li>Community engagement</li>
                                <li>Skill development</li>
                            </ul>',
                'published_at' => now()->subDays(15)
            ],
            [
                'title' => 'Green Technology Workshop Series',
                'slug' => 'green-technology-workshop-series',
                'article_category_id' => $eventsCategory->id,
                'content' => '<p>We are hosting a series of workshops focused on practical green technology applications for businesses and homeowners.</p>
                            <h3>Workshop Schedule</h3>
                            <ul>
                                <li>Solar Energy Basics - October 25, 2024</li>
                                <li>Water Conservation Techniques - November 8, 2024</li>
                                <li>Waste Management Solutions - November 22, 2024</li>
                                <li>Energy Efficiency at Home - December 6, 2024</li>
                            </ul>
                            <p>All workshops are free and open to the public. Registration is required due to limited seating.</p>',
                'published_at' => now()->subDays(2)
            ]
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }

    private function createContactMessages(): void
    {
        $messages = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'message' => 'I am interested in your solar panel systems for my commercial building. Can you provide more information about installation and pricing?',
                'is_read' => true
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@example.com',
                'message' => 'We are organizing a sustainability conference and would like to explore partnership opportunities with your company.',
                'is_read' => false
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'message' => 'Do you offer consulting services for implementing green technology in manufacturing facilities?',
                'is_read' => true
            ]
        ];

        foreach ($messages as $message) {
            ContactMessage::firstOrCreate(
                [
                    'email' => $message['email'],
                    'message' => $message['message']
                ],
                $message
            );
        }
    }
}