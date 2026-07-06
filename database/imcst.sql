-- Adminer 5.4.0 PostgreSQL 18.0 dump

DROP TABLE IF EXISTS "artikel";
DROP SEQUENCE IF EXISTS artikel_id_seq;
CREATE SEQUENCE artikel_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."artikel" (
    "id" bigint DEFAULT nextval('artikel_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "isi" text NOT NULL,
    "status" character varying(255) DEFAULT 'draft' NOT NULL,
    "penulis_id" bigint NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "gambar" character varying(255),
    CONSTRAINT "artikel_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX artikel_slug_unique ON public.artikel USING btree (slug);


DROP TABLE IF EXISTS "berita";
DROP SEQUENCE IF EXISTS berita_id_seq;
CREATE SEQUENCE berita_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."berita" (
    "id" bigint DEFAULT nextval('berita_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "ringkasan" text,
    "isi" text NOT NULL,
    "kategori" character varying(255) DEFAULT 'umum' NOT NULL,
    "penulis_id" bigint NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "gambar_utama" character varying(255),
    "unggulan" boolean DEFAULT false NOT NULL,
    CONSTRAINT "berita_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX berita_slug_unique ON public.berita USING btree (slug);

INSERT INTO "berita" ("id", "judul", "slug", "ringkasan", "isi", "kategori", "penulis_id", "created_at", "updated_at", "gambar_utama", "unggulan") VALUES
(5,	'7 High-Impact Strategies to Skyrocket Custom Product Sales on Your Shopify Store in 2025',	'7-high-impact-strategies-to-skyrocket-custom-product-sales-on-your-shopify-store-in-2025',	'Unlock exponential growth for your custom Shopify store. Learn 7 high-impact strategies for personalization, CRO, and hyper-targeted marketing to boost custom product sales in 2025.',	'<p>Selling personalized or custom products is one of the fastest routes to building a strong brand and securing high margins. However, this niche requires absolute customer confidence before they commit to a purchase. Because every order is unique, customers need validation and a seamless experience before clicking ''Buy''.</p><p>As an SEO expert and content strategist, we’ve broken down the essential strategies successful Shopify merchants are deploying. Here is the definitive roadmap to boost your custom product sales effectively in 2025.</p><h3>1. Prioritize Frictionless Personalization (The CRO King)</h3><p>The single biggest barrier to custom product sales is complexity. If the customization tool is frustrating, your conversion rates will plummet. Your goal must be to make personalization so easy it feels intuitive.</p><ul><li><strong>Invest in Superior Tools:</strong> Use robust Shopify apps, such as <a href="#">Uploadfly Shopify File Uploader</a>, that handle complex inputs (images, text, specific instructions) without lag or error.</li><li><strong>Show Live Previews:</strong> If technically feasible, offer immediate visual feedback. Seeing the design update in real-time dramatically boosts confidence.</li><li><strong>Provide Ultra-Clear Guidance:</strong> Use tooltips and explicit instructions (e.g., “Max 20 Characters,” “Upload High-Resolution JPG”) to prevent confusion and reduce post-sale amendments.</li></ul><h3>2. Leverage High-Fidelity Mockups and Visual Trust</h3><p>In e-commerce, people buy based on visuals. For custom items, this means going beyond generic product photos to show the depth and quality of customization possible.</p><ul><li><strong>Use Professional Mockups:</strong> Showcase customized products in real-life settings rather than flat images. This helps the customer visualize the end result.</li><li><strong>Display Design Range:</strong> Show 3–5 professional examples illustrating the various personalization options available (different fonts, design placements, color combinations).</li><li><strong>Establish Quality Standards:</strong> Explicitly state the quality of materials used and the precision of your customization process.</li></ul><h3>3. Reduce Decision Fatigue with Starter Templates</h3><p>Many potential customers want a personalized item but feel overwhelmed by the blank canvas. Templates serve as powerful starting points, speeding up the path to purchase.</p><ul><li><strong>Offer “Ready-to-Personalize” Designs:</strong> Provide stylish, pre-designed layouts for common personalization needs, such as weddings, birthdays, new babies, or holidays.</li><li><strong>Minimize Required Changes:</strong> Structure templates so customers only need to input a name, date, or a short phrase, significantly lowering the cognitive load.</li></ul><h3>4. Strategically Implement Scarcity and Urgency</h3><p>Injecting a sense of urgency through controlled scarcity motivates immediate action, combating the ''I''ll customize it later'' mindset.</p><ul><li><strong>Launch Limited Edition Custom Designs:</strong> Offer personalization options that are only available seasonally (e.g., “Winter Holiday Font Pack – Ends December 20th”).</li><li><strong>Utilize FOMO Indicators:</strong> Implement countdown timers or low stock indicators on product pages, particularly if your custom product relies on limited materials or fulfillment capacity.</li></ul><h3>5. Harness Authentic Social Proof (UGC is Critical)</h3><p>Social proof is amplified in the custom niche. Customers trust seeing personalized items already purchased and loved by others—especially when they feature User-Generated Content (UGC).</p><ul><li><strong>Encourage Photo Reviews:</strong> Actively solicit customers to upload photos of their completed, personalized products. Offer a small post-purchase incentive (e.g., a 10% discount) for photo submissions.</li><li><strong>Create a Dedicated Gallery:</strong> Establish a visually appealing section, perhaps titled <strong>“Customer Showcase: Real Personalized Orders,”</strong> to display genuine, high-quality UGC.</li></ul><h3>6. Streamline Custom Order Fulfillment and Communication</h3><p>The operational backend must be as smooth as the front end. A confusing or opaque ordering process erodes the trust built during customization.</p><ul><li><strong>Ensure Seamless Data Transfer:</strong> Confirm that all customization data (files, text, placement instructions) transfers perfectly from the app interface (like Uploadfly) to your fulfillment system.</li><li><strong>Provide Detailed Confirmation Emails:</strong> Send a post-order confirmation that includes a clear, visual summary of their personalized requests. This reassurance minimizes customer anxiety and preempts common fulfillment questions.</li></ul><h3>7. Deploy Hyper-Targeted Ads Focused on Emotional Value</h3><p>General advertising wastes budget. Custom products shine when ads target specific life events, appealing to the emotional and gifting aspects of personalization.</p><ul><li><strong>Target Key Life Moments:</strong> Structure your campaigns around specific audiences who are actively purchasing gifts or celebrating milestones (e.g., engaged couples, new homeowners, pet owners).</li><li><strong>Use Dynamic Visuals (Reels/TikTok):</strong> Showcase the transformation process or the emotional reaction of receiving a personalized gift on platforms like Instagram Reels and TikTok, effectively communicating the product''s value.</li></ul><p><strong>Final Strategy: Building Customer Confidence</strong></p><p>Success in custom e-commerce hinges on superior customer experience (CX). By mitigating friction in customization, showcasing real-world examples, and building operational reliability (e.g., integrating a robust tool like <a href="#">Uploadfly Shopify File Uploader</a>), you transition from being a transactional store to a trusted personalization partner. This approach doesn''t just increase sales—it builds loyal, high-lifetime-value customers.</p>',	'Shopify',	1,	'2026-01-23 05:09:46',	'2026-01-23 06:48:07',	'berita/DNI9SHx0Z0_Untitled-design-1-1.png',	'f'),
(4,	'Shopify Store Launch 2025: The Ultimate Step-by-Step Guide for Beginners',	'shopify-store-launch-2025-the-ultimate-step-by-step-guide-for-beginners',	'Ready to start your online business? This ultimate 2025 guide provides 7 simple steps for beginners to launch a profitable, professional Shopify store quickly and efficiently.',	'<h3>Why Start Your E-commerce Journey with Shopify in 2025?</h3><p>Starting your own online business may seem overwhelming, but Shopify eliminates the complexities. It is the leading platform for entrepreneurs globally, making it easier than ever to launch a professional, high-converting online store—even if you are a complete beginner.</p><p>With the right blueprint, you can transform your product idea into a revenue-generating store and start selling in just a few days. Follow this comprehensive, 7-step guide to successfully launch your Shopify store.</p><h3>Step 1: Secure Your Foundation (Sign Up &amp; Branding)</h3><p>The first critical step is claiming your digital space. Go to shopify.com and initiate your free trial. You only need an email address, a password, and a provisional store name (which you can modify later).</p><ul><li><strong>Strategic Branding:</strong> Choose a store name that is memorable, easy to spell, and clearly matches your brand vision.</li><li><strong>Domain Priority:</strong> Secure your store name as a custom domain (e.g., mystore.com) immediately. This builds crucial brand authority and SEO standing.</li></ul><h3>Step 2: Define Your Aesthetic (Theme Selection)</h3><p>Your theme is your digital storefront. Shopify offers hundreds of professionally designed themes (free and paid) that ensure your store looks polished without requiring any coding.</p><ul><li><strong>Mobile-First Approach:</strong> Prioritize themes that are fully responsive. In 2025, the majority of e-commerce traffic and sales come from mobile devices.</li><li><strong>Niche Alignment:</strong> Select a theme whose layout and features complement your specific product style (e.g., a highly visual theme for fashion, or clean structure for electronics).</li></ul><h3>Step 3: Master Your Catalog (Adding Products)</h3><p>Navigate to your Shopify dashboard and select “Products” &gt; “Add Product.” Attention to detail in this step significantly impacts sales conversions.</p><ul><li><strong>High-Quality Media:</strong> Upload clear, professional, and high-resolution images and videos showcasing your product from multiple angles.</li><li><strong>SEO-Optimized Descriptions:</strong> Write compelling product titles and descriptions that incorporate relevant keywords and clearly communicate the product’s value proposition.</li><li><strong>Customization Solution:</strong> If you offer personalized or custom products, install essential apps like <strong>Uploadfly Shopify File Uploader</strong>. This streamlines the process by allowing customers to easily upload images, files, or custom text during the ordering process.</li><li><strong>Configuration Check:</strong> Accurately set pricing, inventory levels, and specific shipping weights.</li></ul><h3>Step 4: Establish Payment Gateways</h3><p>You need a secure, reliable way to process transactions globally. Shopify simplifies the setup of critical payment methods:</p><ul><li><strong>Shopify Payments:</strong> The native, hassle-free way to accept all major credit and debit cards.</li><li><strong>Third-Party Options:</strong> Integrate trusted services like PayPal, Apple Pay, and Google Pay.</li></ul><p><strong>Expert Tip:</strong> Offering multiple payment options builds customer trust and reduces cart abandonment, especially for international buyers.</p><h3>Step 5: Configure Shipping and Logistics</h3><p>Clear, transparent shipping policies are essential for minimizing confusion and maximizing customer satisfaction.</p><p>Determine the best fulfillment strategy for your business:</p><ul><li><strong>Strategic Rates:</strong> Choose between Free Shipping (often a great marketing tool), Flat-Rate Shipping, or Carrier-Calculated Shipping (real-time rates from FedEx, DHL, or UPS).</li></ul><p><strong>Crucial Action:</strong> Ensure your shipping rates and return policies are highly visible. Transparency is key to long-term trust.</p><h3>Step 6: Build Authority Pages</h3><p>A professional store requires more than just product listings. These essential pages build credibility and improve customer experience:</p><ul><li><strong>Home Page:</strong> Must clearly showcase your bestsellers and unique value proposition.</li><li><strong>About Us:</strong> Share your brand story and mission to create an emotional connection.</li><li><strong>Contact Us:</strong> Provide easy, reliable avenues for customer support.</li><li><strong>FAQ:</strong> Proactively address common queries before customers have to ask.</li><li><strong>Return/Refund Policy:</strong> Clearly defined policies establish legal compliance and trust.</li></ul><h3>Step 7: Execute the Grand Launch</h3><p>Once you are fully satisfied with the setup, it’s time to go live and drive traffic!</p><ol><li><strong>Remove Password Protection:</strong> Disable the store password to open access to the public.</li><li><strong>Test Transactions:</strong> Run a full end-to-end test order to confirm all payment and checkout sequences are flawless.</li><li><strong>Ignite Marketing:</strong> Immediately share your store link across all platforms: social media campaigns, email newsletters, and targeted introductory ads.</li></ol><h3>Bonus Growth Strategies for Beginners</h3><ul><li><strong>Utilize Apps for Scalability:</strong> Leverage the Shopify App Store for advanced features like live chat, email capture pop-ups, and robust file upload management for personalized items.</li><li><strong>Focus on Retention:</strong> Begin collecting emails from Day 1—email marketing remains the highest ROI channel in e-commerce.</li><li><strong>Analyze and Adapt:</strong> Consistently use Shopify Analytics to understand customer behavior, identify conversion roadblocks, and continuously optimize your store design and offerings.</li></ul><p><strong>Final Thoughts:</strong> Launching a successful online business in 2025 starts with a powerful platform. By following this definitive guide, you leverage Shopify’s infrastructure, positioning yourself for sustainable growth, whether you sell physical goods, digital downloads, or complex custom-made items. Take the leap today—your e-commerce dream is ready to launch!</p>',	'Shopify',	1,	'2026-01-23 05:09:45',	'2026-01-23 06:50:08',	'berita/kVrdEZr991_Untitled-design-3.png',	'f'),
(3,	'Launch Your Shopify Custom Product Store: Get 4 Months FREE Access to Uploadfly File Uploader App',	'launch-your-shopify-custom-product-store-get-4-months-free-access-to-uploadfly-file-uploader-app',	'Launch your new Shopify custom store and get 4 months of FREE access to Uploadfly, the ultimate file uploader app. Perfect for personalized products!',	'<h1>Launch Your Shopify Custom Product Store: Get 4 Months FREE Access to Uploadfly File Uploader App</h1><p>Dreaming of launching a thriving online store specializing in custom and personalized products? Now is the perfect time, and we''re giving your business a massive head start!</p><p>When you open your new <strong>Shopify store</strong> through our special partner link, you will receive an exclusive <strong>4 months of FREE access</strong> to the <strong>Uploadfly app</strong> on any plan. Uploadfly is the ultimate file uploader solution, essential for businesses selling personalized t-shirts, custom gifts, unique art prints, and more.</p><hr><h2>The Exclusive Uploadfly Offer for New Shopify Merchants</h2><p>This limited-time promotion is designed to help new merchants optimize their workflow and boost sales of customized items right from day one.</p><h3>Why This Offer is Unbeatable:</h3><ul><li><strong>Cost Savings:</strong> Eliminate app subscription costs for 4 critical months.</li><li><strong>Seamless Customization:</strong> Provide customers with the best way to upload necessary files, images, or text.</li><li><strong>Growth Tool:</strong> Start your business with a professional, high-converting file upload solution.</li></ul><h2>How to Claim Your Free 4-Month Uploadfly App Access</h2><p>Getting started is straightforward. Follow these steps to ensure you qualify for your free premium access:</p><ol><li><strong>Join Shopify Using Our Special Link</strong><p>Click and register through this exclusive link: <strong>👉 [Join Here]</strong></p><p><strong>Important Optimization Tip:</strong> Make sure you complete your signup using this specific partner link. This action is mandatory to be eligible for the free app offer.</p></li><li><strong>Set Up Your Shopify Store Foundation</strong><p>Create a solid foundation for your custom products business:</p><ul><li>Choose a memorable store name optimized for search.</li><li>Add your initial product listings (especially personalized items).</li><li>Customize your theme for a professional brand look.</li><li>Set up essential payment and shipping methods.</li></ul></li><li><strong>Install the Uploadfly App</strong><p>Once your new store is ready to handle orders:</p><ul><li>Go to the Shopify App Store.</li><li>Search for <strong>"Uploadfly File Uploader"</strong>.</li><li>Install the app directly to your store.</li></ul><p>Uploadfly seamlessly integrates, allowing your customers to easily upload images, text, or files—a crucial feature for any store offering personalization.</p></li><li><strong>Activate Your 4-Month Free Access</strong><p>After installing Uploadfly, contact our administration team via email with your store URL to trigger the activation of your free 4-month premium plan.</p><p>Email: <code>admin@imakecustom.com</code></p></li></ol><hr><h2>Boost Conversions with Uploadfly: The Custom Product Specialist App</h2><p>Uploadfly isn''t just an app; it''s a powerful tool designed for merchants focused on personalization. Optimizing your store with Uploadfly means optimizing for sales.</p><h3>Key Benefits for Your Custom Product Shopify Store:</h3><ul><li>✅ <strong>Easy Customer Uploads:</strong> Allows shoppers to easily upload images or input text specifications.</li><li>✅ <strong>Perfect for High-Value Custom Goods:</strong> Specifically built for personalized t-shirts, mugs, prints, jewelry, and bespoke services.</li><li>✅ <strong>Elevates CX &amp; Sales:</strong> A streamlined upload process reduces friction, boosting customer experience and conversion rates.</li><li>✅ <strong>Developer-Free Setup:</strong> Easy installation and setup—absolutely no coding knowledge is needed!</li></ul><p>Whether you are selling unique gifts, personalized apparel, digital art prints, or anything requiring customer input, <strong>Uploadfly</strong> helps you deliver a professional and streamlined customization experience.</p><p><strong>Don’t Wait! Launch Your Dream Store Today!</strong></p><p>Take advantage of this exclusive, limited-time offer. Start building a profitable online business with the right tools from the beginning and get 4 months of the essential <strong>Uploadfly custom product app access for FREE</strong>.</p><p><strong>👉 [Click here to start now and claim your free access!]</strong></p>',	'umum',	1,	'2026-01-23 05:09:44',	'2026-01-23 08:03:29',	'berita/VX2TBBwHj3_Untitled-design-2.png',	'f'),
(2,	'The Ultimate Guide to Choosing the Best Shopify Theme for Maximum Sales & Conversions',	'the-ultimate-guide-to-choosing-the-best-shopify-theme-for-maximum-sales-conversions',	'Unlock higher profits! Learn 7 expert tips for choosing the best Shopify theme focused on speed, essential CRO features, and mobile responsiveness to maximize your e-commerce sales.',	'<p>Choosing the right Shopify theme can make or break your online business. Your store’s design profoundly affects how customers perceive your brand, navigate your site, and ultimately, whether or not they complete a purchase. By selecting a theme optimized for speed and Conversion Rate Optimization (CRO), you lay the groundwork for sustainable sales growth.</p>

<h2>Expert Tips for Choosing the Perfect Shopify Theme to Increase Sales</h2>
<p>Here are crucial steps and expert strategies to help you select a Shopify theme that drives maximum conversions:</p>

<h3>1. 💨 Prioritize Fast and Mobile-Responsive Themes (SEO &amp; AEO Priority)</h3>
<p>Speed matters—every extra second of loading time could mean lost sales and a lower search engine ranking. Prioritize themes that load instantaneously and offer flawless performance on mobile devices, where over 70% of e-commerce traffic originates.</p>
<p><strong>Pro Tip:</strong> Before purchasing, test theme demos using <strong>Google PageSpeed Insights</strong> or GTmetrix to ensure top-tier loading performance.</p>

<h3>2. 🧼 Clean, Focused Design &amp; User Experience (UX)</h3>
<p>A successful theme emphasizes products, not clutter. Opt for designs featuring ample white space, high-quality product imagery, and strategically placed, bold <strong>Call-to-Action (CTA) buttons</strong>.</p>
<p><strong>Essential Design Elements for Sales:</strong></p>
<ul>
    <li>Large, high-resolution product photos and galleries.</li>
    <li>Clear pricing and instantly visible "Add to Cart" buttons.</li>
    <li>Intuitive and easy-to-navigate main menus.</li>
</ul>

<h3>3. 🛒 Match the Theme to Your Product Niche</h3>
<p>Different product types require specialized user experiences. Selecting a theme tailored to your niche ensures you have the necessary functionality out-of-the-box:</p>
<ul>
    <li><strong>Fashion/Apparel:</strong> Needs robust product filtering, swatch options, zoomable images, and clean grid layouts.</li>
    <li><strong>Electronics/Tech:</strong> Benefits from comparison tables, detailed specifications, and customer review modules.</li>
    <li><strong>Custom/Personalized Goods:</strong> Requires seamless file upload capabilities for customer designs or logos.</li>
</ul>

<h3>4. 🚀 Look for Conversion Rate Optimization (CRO) Features</h3>
<p>The best themes are designed with conversion in mind. Look for built-in features that minimize friction and create urgency:</p>
<ul>
    <li><strong>Sticky “Add to Cart” buttons</strong> (stays visible while scrolling).</li>
    <li>Product quick view functionality.</li>
    <li>Scarcity triggers (e.g., countdown timers or low-stock alerts).</li>
    <li>Trust badges (e.g., secure checkout logos, free shipping guarantees).</li>
</ul>

<h3>5. 🔌 Ensure Seamless Compatibility with Essential Apps</h3>
<p>Your theme must integrate smoothly with essential Shopify apps that manage logistics, marketing, and enhance UX.</p>
<p><strong>📢 Crucial Tip for Custom Product Sellers:</strong> If your business model involves personalized, made-to-order items, collecting customer files (images, logos, text instructions) is critical. Utilizing specialized apps like <strong>UploadFly – Shopify File Upload App</strong> is essential. It integrates perfectly with standard themes, allowing customers to upload necessary files directly on the product page without compromising store speed or UX.</p>

<h3>6. 🛠️ Easy Customization Without Coding</h3>
<p>Future-proof your store by choosing themes that support drag-and-drop blocks and flexible layouts via the native Shopify editor. You need the freedom to quickly tweak colors, fonts, and page sections without needing a developer.</p>

<h3>7. ⭐ Read Reviews &amp; Verify Developer Support</h3>
<p>Invest in themes from reputable, well-reviewed developers. Ensure they provide rapid customer support, regular updates for security and compatibility, and comprehensive documentation.</p>

<h2>🏆 Top Performing Shopify Themes Optimized for Sales Growth</h2>
<p>These themes are often highlighted by experts for their speed and conversion-focused design:</p>
<table>
<thead>
<tr>
<th>Theme Name</th>
<th>Best For</th>
<th>Strengths</th>
</tr>
</thead>
<tbody>
<tr>
<td><strong>Dawn</strong></td>
<td>All Stores/Beginners</td>
<td>Free, extremely fast, modern layout, highly mobile-optimized.</td>
</tr>
<tr>
<td><strong>Impulse</strong></td>
<td>General &amp; Promo-Heavy</td>
<td>Built-in promotional sections, marketing banners, and flexible sections.</td>
</tr>
<tr>
<td><strong>Prestige</strong></td>
<td>Luxury/Fashion Brands</td>
<td>Visual storytelling capabilities, high-end aesthetic, excellent image display.</td>
</tr>
<tr>
<td><strong>Debutify</strong></td>
<td>Beginners/CRO-Focused</td>
<td>Free version available, numerous built-in marketing add-ons (eliminates many paid apps).</td>
</tr>
</tbody>
</table>

<h2>✅ Final Recommendation for E-commerce Success</h2>
<p>Never choose a theme solely based on aesthetics. Always use this guiding principle:</p>
<p><strong>“Will this design minimize friction and make it easier for my customers to purchase my products?”</strong></p>
<p>By selecting a high-speed, CRO-optimized theme and integrating powerful tools like UploadFly for specific functional needs, you guarantee a frictionless shopping experience that consistently converts visitors into loyal, repeat buyers.</p>',	'umum',	1,	'2026-01-23 05:09:42',	'2026-01-24 03:17:52',	'berita/nSbpbhKgc3_Copy-of-Uploadfly-800-x-800-px.png',	'f'),
(8,	'Top 10 Trending Custom Products to Sell for Profit in 2025',	'top-10-trending-custom-products-to-sell-for-profit-in-2025',	'Boost your Shopify sales! Discover the Top 10 trending custom products for 2025, from AI art prints and personalized tech to eco-totes. Start selling high-demand items today!',	'<h1>Top 10 Trending Custom Products to Sell for Profit in 2025</h1>
<p>In 2025, customization will not just be a luxury—it will be an expectation. Customers actively seek products that reflect their unique style, values, or celebrate special moments. If you run an e-commerce platform, especially a Shopify store, offering high-quality personalized items is the fastest way to stand out from the competition, build brand loyalty, and significantly increase your profit margins.</p>

<h2>Maximize Sales: 10 High-Demand Custom Products for the E-commerce Market:</h2>
<ol>
<li><strong>Custom AI-Generated Art Prints:</strong> Leveraging generative AI, these prints transform customer photos into unique, stylized artworks. High demand for modern wall decor and unforgettable, instantly generated gifts.</li>
<li><strong>Personalized Smartwatch Bands:</strong> Capitalize on the wearable tech boom. Offer custom bands featuring names, unique textures, favorite colors, or motivational quotes.</li>
<li><strong>Custom Eco-Friendly Tote Bags (Sustainable Prints):</strong> Sustainability drives purchasing decisions. Personalized, reusable totes with custom prints, logos, or slogans align with conscious consumers'' values and are highly shareable.</li>
<li><strong>3D-Printed Bespoke Phone Cases:</strong> Move beyond basic plastic. Offer 3D-printed custom cases that allow for unique textures, detailed initials, or complex, one-of-a-kind designs.</li>
<li><strong>Personalized Pet Portrait Blankets:</strong> The booming pet market loves personalization. Custom blankets featuring detailed pet portraits or names are emotionally resonant, high-value items.</li>
<li><strong>Custom Recipe Books (Family Legacy):</strong> Target foodies and tradition keepers. Allow customers to compile and design beautiful, custom-printed books featuring their favorite family recipes and stories.</li>
<li><strong>Engraved Wireless Earbuds Cases:</strong> As essential tech accessories, custom-engraved cases (with initials, names, or minimalistic designs) offer a practical way for users to personalize and identify their gear.</li>
<li><strong>Personalized Fitness Gear (Motivation Focused):</strong> Inspire your customers. Offer custom yoga mats, gym bags, and water bottles featuring personalized quotes, graphics, or names tailored to their fitness journey.</li>
<li><strong>Custom LED Neon Signs:</strong> A massive social media trend for weddings, home offices, and modern decor. Enable easy design options for special messages, business logos, or unique symbols.</li>
<li><strong>Tailored Virtual/Hybrid Event Kits:</strong> Service the B2B and remote work market. Customized event kits—including high-quality, branded merchandise like apparel, notebooks, and specialty snacks—delivered directly to attendees’ doors.</li>
</ol>

<h2>The Key to Custom Success: Seamless File Upload (Uploadfly Integration)</h2>
<p>No matter which high-profit custom products you choose, the customer experience hinges on an easy and reliable personalization process. This is where tools like the <strong>Uploadfly Shopify File Uploader</strong> become essential. Uploadfly minimizes friction by allowing your customers to upload images, logos, documents, or special instructions directly and effortlessly on your product pages. This secure, organized system ensures files are correctly attached to every order.</p>

<p><strong>With Uploadfly, you optimize conversion rates through:</strong></p>
<ul>
<li>Simple drag-and-drop functionality</li>
<li>Support for all multiple file types (images, vectors, documents)</li>
<li>Customizable upload fields for specific instructions</li>
<li>Secure, organized file delivery linked directly to the order</li>
</ul>
<p>If you are serious about capitalizing on the demand for personalized products in 2025, integrating a robust upload solution like Uploadfly is the crucial step to maximizing efficiency and sales.</p>
<p><strong>Ready to elevate your Shopify store? Start offering these trending custom products today and simplify your operations with Uploadfly!</strong></p>',	'Shopify',	1,	'2026-01-23 05:09:50',	'2026-01-23 06:22:45',	'berita/wk4vABuPXi_Best-app-shopify-for-custom-product.jpg',	'f'),
(9,	'UploadFly: The Best Shopify File Uploader App for Custom Products | Conditional Logic & Dynamic Pricing',	'uploadfly-the-best-shopify-file-uploader-app-for-custom-products-conditional-logic-dynamic-pricing',	'UploadFly is the ultimate Shopify file uploader app. Enable multi-file uploads, conditional logic, dynamic pricing, and a built-in image editor for custom products & maximum revenue.',	'<h1>UploadFly: The Best Shopify File Uploader App for Custom Products | Conditional Logic &amp; Dynamic Pricing</h1>

<p>In the competitive realm of e-commerce, offering personalized products and collecting specific customer data is crucial for growth. <strong>UploadFly</strong> emerges as the premier, user-friendly file uploader application meticulously engineered to integrate seamless file uploading capabilities directly into your <strong>Shopify store</strong>.</p>

<p>Whether you manage a niche boutique or a high-volume custom e-commerce operation, UploadFly provides the robust toolset necessary to effortlessly gather customer files, images, or necessary documentation during the purchase process.</p>

<h2 id="revolutionize-custom-product-workflow">🚀 Revolutionize Your Custom Product Workflow with UploadFly</h2>

<p>UploadFly simplifies the often-complex setup of custom product options. With just a few clicks, you can enable customers to upload multiple files simultaneously, significantly saving time and elevating the overall shopping experience.</p>

<p>Crucially, UploadFly allows merchants to implement <strong>dynamic additional pricing tiers</strong> based on uploaded files. This feature is indispensable for stores specializing in personalized merchandise, printing services, or complex customized products, turning required file submission into a direct revenue stream.</p>

<h3 id="core-features-that-drive-conversion">✨ Core Features That Drive Conversion: The UploadFly Advantage</h3>

<p>UploadFly is packed with advanced features designed to maximize conversion rates and streamline product configuration:</p>

<ul>
    <li><strong>Multi-file Uploads:</strong> Facilitate large or complex orders by allowing customers to easily upload several files at once directly onto the product page.</li>
    <li><strong>Intelligent Conditional Logic:</strong> Simplify product forms by displaying or hiding specific upload fields based on the customer’s prior selections (e.g., product variant or required input). This is crucial for maximizing AEO visibility.</li>
    <li><strong>Built-in Image Editor:</strong> Ensure optimal file quality and reduce post-purchase friction. Customers can crop, resize, and adjust images before submission—a key feature for personalized products.</li>
    <li><strong>Dynamic Additional Pricing:</strong> Automatically apply extra charges based on the number of files uploaded or the complexity required for product customization, maximizing revenue potential.</li>
    <li><strong>Universal Theme Compatibility (SEO Optimized):</strong> Seamlessly integrate with virtually any Shopify theme without disrupting your store’s design or user flow, preserving fast load times (critical for SEO ranking) and a professional aesthetic.</li>
    <li><strong>Non-Intrusive UX:</strong> Maintains your store''s native user experience, ensuring a smooth and uninterrupted journey for your customers.</li>
</ul>

<h2 id="global-expansion-and-future">🌍 Global Expansion: Beyond Shopify and E-commerce File Upload Solutions</h2>

<p>Currently, UploadFly is the dedicated file upload solution for Shopify merchants worldwide. We are optimizing our infrastructure for global reach (GEO). However, we are thrilled to announce our ambitious expansion roadmap. We plan to extend availability to other major e-commerce platforms, including Etsy and BigCommerce, in the near future, bringing our intuitive file upload capabilities to a broader global network of sellers.</p>

<h2 id="why-uploadfly-is-the-best-uploader-app">💡 Why UploadFly is the Ultimate Uploader App for E-commerce Success?</h2>

<p>UploadFly stands out as an easy-to-set-up, fully compatible, and feature-rich solution for complex customization needs. It eliminates checkout roadblocks, guarantees file quality, and maximizes revenue potential through dynamic pricing and intelligent conditional logic.</p>

<p>Start empowering your Shopify store today with <strong>UploadFly</strong> — the ultimate <strong>file uploader application</strong> designed for the modern custom e-commerce market.</p>',	'umum',	1,	'2026-01-23 05:09:51',	'2026-01-23 06:35:54',	'berita/AsszGKEAoJ_Copy-of-Uploadfly-Website.png',	'f'),
(7,	'POD vs. In-House Printing: The Ultimate Fulfillment Strategy Guide for Custom Shopify Stores in 2024',	'pod-vs-in-house-printing-the-ultimate-fulfillment-strategy-guide-for-custom-shopify-stores-in-2024',	'Shopify custom product owners must choose between low-risk POD or high-margin In-House printing. Compare costs, quality control, and scalability for 2024 success.',	'<h3>Navigating Fulfillment: The Critical Choice for Custom Product E-commerce</h3><p>For Shopify store owners specializing in custom merchandise, the decision between utilizing <strong>Print on Demand (POD)</strong> services and managing production <strong>In-House (Direct-to-Consumer/DTC Printing)</strong> is the most crucial strategic choice. Each model presents distinct advantages and challenges, profoundly impacting your profit margins, operational complexity, and long-term scaling potential. This detailed comparison will guide you in determining the optimal fulfillment pathway for your unique e-commerce brand.</p><h3>Strategic Comparison: POD vs. In-House Production</h3><p>We analyze both models across key business metrics essential for sustainable e-commerce growth:</p><table width="100%" border="1" cellpadding="5" cellspacing="0"><thead><tr><th>Feature</th><th>Print on Demand (POD)</th><th>In-House Production (DTC)</th></tr></thead><tbody><tr><td><strong>Initial Capital &amp; Risk</strong></td><td>Low – Zero inventory commitment and no equipment purchases needed. Risk is minimal (pay-as-you-sell model).</td><td>High – Significant upfront investment required for machinery, raw materials, and dedicated operational space. High inventory risk (unsold stock).</td></tr><tr><td><strong>Profit Margins</strong></td><td>Lower – Suppliers take a cut for fulfillment and logistics, reducing the Cost of Goods Sold (COGS) efficiency.</td><td>Higher – Full control over production costs and pricing structure, maximizing long-term profitability.</td></tr><tr><td><strong>Quality Control (QC)</strong></td><td>Limited – Reliance on the POD supplier’s standards and reliability. QC issues are harder to troubleshoot.</td><td>Full Control – Direct oversight of every production aspect, enabling guaranteed premium quality and immediate adjustments.</td></tr><tr><td><strong>Product Customization</strong></td><td>Restricted to the supplier''s catalog and available printing methods.</td><td>Virtually Unlimited – Freedom to experiment with unique materials, specialized printing techniques, and bespoke product lines.</td></tr><tr><td><strong>Time Commitment</strong></td><td>Minimal Operational Load – Focus remains sharply on design development, branding, and digital marketing strategies.</td><td>High Operational Load – Requires handling production scheduling, inventory management, warehousing, packaging, and shipping logistics.</td></tr><tr><td><strong>Scalability</strong></td><td>Frictionless – POD vendors manage fulfillment volume, simplifying rapid scaling during peak demand or viral growth.</td><td>Challenging – Scaling requires manual expansion (acquiring more machinery, space, hiring staff, and system integration).</td></tr><tr><td><strong>Setup Speed</strong></td><td>Rapid Deployment – Stores can often launch and integrate fulfillment within days, facilitating rapid market testing.</td><td>Slower Implementation – Requires time for operational setup, material sourcing, machinery testing, and workflow optimization.</td></tr></tbody></table><h3>Which Fulfillment Model Should Your Shopify Store Choose?</h3><p>Selecting the right path depends heavily on your current resources and strategic priorities:</p><h4>Choose Print on Demand (POD) if:</h4><ul><li>You need to launch quickly with minimal financial risk and low initial capital investment.</li><li>Your primary focus is market testing new niches, designs, or business ideas before committing major funds.</li><li>You prioritize focusing 90% of your effort on digital marketing, SEO, and brand building.</li><li>You require frictionless, immediate scalability without the headache of inventory management.</li></ul><h4>Choose In-House Printing (DTC) if:</h4><ul><li>You are targeting significantly higher long-term profit margins and demand absolute brand and quality control.</li><li>You possess the capital and operational readiness to invest in specialized equipment, raw materials, and dedicated production space.</li><li>You plan to offer highly unique, bespoke customization, premium packaging, or use materials that standard POD platforms cannot handle.</li></ul><h3>Pro Tip: Streamlining the Customization Workflow</h3><p>Regardless of your chosen production method, providing customers with an intuitive and seamless way to upload their custom designs or images is fundamental to e-commerce success. This is where specialized tools like the <strong>Uploadfly Shopify File Uploader</strong> excel. By allowing customers to upload files directly during the ordering process, you minimize order errors and dramatically simplify the workflow for custom orders.</p><p>If your store features customizable products, utilizing an integrated solution like Uploadfly can significantly elevate the customer experience and streamline your order processing, whether you are printing items in-house or coordinating fulfillment with a POD partner.</p><h3>Conclusion</h3><p>Both Print on Demand and In-House Production offer viable, distinct pathways to building a thriving custom product business on Shopify. Choose the option that best aligns with your current resources, technical skills, and strategic vision for growth. Remember, your fulfillment strategy is flexible—you can always evolve your operations and scale methods as your business matures.</p>',	'Shopify',	1,	'2026-01-23 05:09:49',	'2026-01-23 06:42:59',	'berita/64SYNKQGfh_print-on-deman-vs-printing-by-yourself.png',	'f'),
(6,	'The E-commerce Secret Weapon: 6 Reasons Why Shopify Merchants Must Embrace Product Personalization',	'the-e-commerce-secret-weapon-6-reasons-why-shopify-merchants-must-embrace-product-personalization',	'Unlock premium pricing and skyrocket CLV by integrating custom products into your Shopify store. Discover 6 strategic reasons to embrace personalization for e-commerce growth and differentiation.',	'<h1>The E-commerce Secret Weapon: 6 Reasons Why Shopify Merchants Must Embrace Product Personalization</h1><p>In the fiercely competitive landscape of modern e-commerce, merely selling quality products is no longer enough. The consumer shift is undeniable: shoppers are migrating away from mass-produced commodities and prioritizing items that offer meaning, connection, and uniqueness. For Shopify merchants aiming for sustainable growth and higher profitability, offering custom products is not just a strategic advantage—it is a foundational pillar for future success.</p><p>Personalization fundamentally changes the relationship between a customer and your brand. Here are six compelling reasons why integrating custom products is the smartest move you can make for your Shopify business:</p><h3>1. Skyrocket Customer Lifetime Value (CLV) through Emotional Connection</h3><p>When customers actively participate in the creation process—whether by adding a name, a unique date, or a custom design—they develop a profound emotional investment in the product. This personalized item transcends a simple transaction; it becomes a meaningful keepsake. This translates directly into quantifiable business benefits:</p><ul><li><strong>Increased Repeat Purchases:</strong> Customers return to brands that offer unique, meaningful experiences.</li><li><strong>Stronger Brand Advocacy:</strong> Personalized items lead to enthusiastic word-of-mouth marketing.</li><li><strong>Higher Retention Rates:</strong> The emotional bond makes switching to a competitor less likely.</li></ul><h3>2. Escape the Price War: Achieve True Competitive Differentiation</h3><p>Operating in saturated markets often forces merchants into a relentless race to the bottom on pricing. Offering custom products allows you to sidestep this painful competition. Instead of competing on cost, you compete on unparalleled value and distinctiveness.</p><p><strong>Example:</strong> While every competitor sells a generic notebook, your brand sells a notebook featuring custom foil stamping, a user-uploaded image, or a proprietary engraved message. This custom value is significantly harder for mass-market retailers to replicate, establishing your brand in a unique market niche.</p><h3>3. Unlock Higher Profit Margins and Premium Pricing Power</h3><p>Customization inherently increases the perceived value of an item. Consumers are demonstrably willing to pay a premium for a product tailored specifically to their tastes or needs. This allows you to implement a more robust premium pricing strategy.</p><p><strong>Analysis:</strong> If a standard, blank mug sells for $12, a mug personalized with a customer''s family photo or an inside joke can easily command $25 or more. The increase in production cost is marginal, but the potential profit increase is exponential.</p><h3>4. Capitalize on Gifting: Maximize Seasonal and Year-Round Revenue</h3><p>Custom products are the undisputed champions of the gift economy. Whether it’s a birthday, an anniversary, a wedding, or graduation, people seek out gifts that demonstrate thoughtfulness and care. Personalization fulfills this need perfectly.</p><p>By positioning your offerings as ideal personalized gifts, your store can:</p><ul><li>Maximize revenue during peak seasonal sales (Q4 holidays, Valentine’s Day, Mother’s Day).</li><li>Establish a steady, lucrative stream of year-round sales outside major holiday spikes.</li></ul><h3>5. Drive Deeper Engagement by Making Customers Co-Creators</h3><p>The act of customizing an item—selecting colors, uploading graphics, or positioning text—turns a passive shopper into an active co-creator. This level of interaction not only elevates the shopping experience but also significantly reduces bounce rates and boosts conversion potential.</p><p><strong>Seamless Shopify Implementation:</strong> Achieving this high level of engagement must be friction-free. Tools like <strong>Uploadfly – Shopify File Uploader</strong> are essential, allowing customers to easily and seamlessly upload images, design files, or personalization text directly during the ordering process, ensuring a smooth customer journey and reliable order data for your team.</p><h3>6. Future-Proof Your Brand: Setting the Standard for Modern E-commerce</h3><p>Personalization is not a fleeting trend; it is the fundamental expectation of the next generation of digital consumers. Brands that proactively integrate customization features are not just keeping up with the market—they are setting the standard for it.</p><p>By prioritizing custom products, you are ensuring your business is:</p><ul><li><strong>Agile and Adaptive:</strong> Ready to meet evolving consumer demands.</li><li><strong>Data-Rich:</strong> Gaining invaluable insights into specific customer preferences and popular customization options.</li><li><strong>Positioned for Longevity:</strong> Building a brand identity centered on uniqueness and customer-centric value.</li></ul><p><strong>Conclusion: Implement Personalization for Unstoppable Growth</strong></p><p>Custom products are your brand’s secret weapon for building deeper relationships and unlocking premium revenue streams in a saturated market. For Shopify merchants, the entry barrier is lower than ever. Stop competing on price and start competing on unique value. Integrate a robust customization solution like <strong>Uploadfly – Shopify File Uploader</strong> today and transform your customers into enthusiastic brand advocates.</p>',	'Shopify',	1,	'2026-01-23 05:09:47',	'2026-01-23 06:43:40',	'berita/kbjcQ1vrAP_Untitled-design-1.png',	'f'),
(1,	'UploadFly Launches as the Ultimate FREE File Uploader App for Shopify: Simplify Custom Orders & Collect Customer Files Seamlessly',	'uploadfly-launches-as-the-ultimate-free-file-uploader-app-for-shopify-simplify-custom-orders-collect-customer-files-seamlessly',	'UploadFly is the ultimate FREE file uploader app for Shopify. Collect artwork, images, and files directly on product pages. Simplify custom orders and boost workflow efficiency today!',	'<p>For Shopify merchants specializing in customization, print-on-demand, or personalized goods, collecting necessary customer files—be it artwork, logos, or high-resolution images—is often the biggest hurdle in the fulfillment process. Chasing emails and sorting through disorganized attachments slows down production and degrades the customer experience.</p>
<p>We are thrilled to introduce <strong>UploadFly for Shopify</strong>, the dedicated, 100% free solution designed to eliminate this friction. UploadFly seamlessly integrates professional file uploads directly into your Shopify store''s product and cart pages, transforming how you manage custom orders.</p>

#image_title

<h3>Stop Chasing Files: Built-in Uploads Transform Your Workflow</h3>
<p>Whether you manage complex print jobs, offer detailed monogramming, or require specific documentation for digital services, UploadFly ensures that customers can submit essential assets (images, PDFs, artwork, and more) precisely when they place their order.</p>
<p>This critical integration removes the need for cumbersome third-party forms or confusing email chains, centralizing all order-related files within your secure Shopify ecosystem. Focus on fulfilling orders, not managing files.</p>

<h3>Game Changer: Permanently Free and Feature-Rich</h3>
<p>In a major commitment to supporting all Shopify merchants, we are excited to announce that the UploadFly Shopify App is now <strong>100% FREE to install and use</strong>. This is not a limited trial—it means zero subscriptions, zero hidden fees, and full access to powerful features designed for scaling businesses.</p>

<h3>Core Features Driving Order Efficiency</h3>
<ul>
    <li><strong>Seamless, Multi-Location Uploads:</strong> Allow customers to upload files (images, documents, etc.) during the product selection, in the cart, or even after checkout, ensuring maximum flexibility.</li>
    <li><strong>Granular Customization Controls:</strong> Maintain complete control over the upload environment by setting allowed file types (e.g., .jpg, .svg, .pdf), defining size limits, and customizing the appearance of the upload fields to match your brand.</li>
    <li><strong>Secure, Centralized File Management:</strong> All uploaded files are stored securely in your dedicated UploadFly dashboard. Direct download links are automatically tied to the corresponding Shopify order for easy retrieval and auditing.</li>
    <li><strong>Optimized for Custom Merchants:</strong> Specifically tailored to meet the rigorous demands of custom product stores, including print shops, embroidery services, and personalized gifting.</li>
    <li><strong>Data Security Assurance:</strong> We prioritize customer trust. All file transfers and storage utilize secure, encrypted protocols, safeguarding customer data throughout the process.</li>
</ul>

<h3>Who Needs UploadFly?</h3>
<p>UploadFly is the essential tool for any Shopify merchant whose business relies on customer-provided assets:</p>
<ul>
    <li>Custom Product Retailers (T-shirts, mugs, engraving, personalized jewelry)</li>
    <li>Digital Service Providers (Resume editing, design services, consulting)</li>
    <li>Photographers &amp; Professional Print Labs</li>
    <li>Any seller seeking a professional, friction-free method to collect essential documents or media directly during the purchase path.</li>
</ul>

<h3>Get Started Today: Installation is Instant and Free</h3>
<p>Streamline your operations in three simple steps:</p>
<ol>
    <li>Search for <strong>UploadFly</strong> in the official Shopify App Store.</li>
    <li>Click <strong>Install</strong> – it costs absolutely nothing.</li>
    <li>Configure your file requirements and start receiving professional customer uploads immediately.</li>
</ol>
<p>🔗 <strong>Install UploadFly Free from the Shopify App Store</strong></p>

<p>UploadFly allows you to shift focus back to order fulfillment and scaling your business, confident that file collection is handled efficiently and professionally. Boost customer satisfaction, simplify your back-end, and do it all for free.</p>
<p><strong>UploadFly: The easiest and most reliable way to collect files on Shopify.</strong></p>',	'umum',	1,	'2026-01-23 05:09:40',	'2026-01-24 03:18:31',	'berita/6cwYu2wTg8_Copy-of-Uploadfly-Website.png',	'f');

DROP TABLE IF EXISTS "berita_memiliki_kategori";
CREATE TABLE "public"."berita_memiliki_kategori" (
    "berita_id" bigint NOT NULL,
    "kategori_id" bigint NOT NULL,
    CONSTRAINT "berita_memiliki_kategori_pkey" PRIMARY KEY ("berita_id", "kategori_id")
)
WITH (oids = false);

INSERT INTO "berita_memiliki_kategori" ("berita_id", "kategori_id") VALUES
(1,	4),
(2,	4),
(3,	4),
(9,	4),
(8,	1),
(7,	1),
(6,	1),
(5,	1),
(4,	1);

DROP TABLE IF EXISTS "berita_memiliki_tag";
CREATE TABLE "public"."berita_memiliki_tag" (
    "berita_id" bigint NOT NULL,
    "tag_id" bigint NOT NULL,
    CONSTRAINT "berita_memiliki_tag_pkey" PRIMARY KEY ("berita_id", "tag_id")
)
WITH (oids = false);

INSERT INTO "berita_memiliki_tag" ("berita_id", "tag_id") VALUES
(8,	9),
(8,	10),
(8,	11),
(8,	12),
(8,	13),
(8,	14),
(8,	15),
(8,	7),
(7,	16),
(7,	9),
(7,	20),
(9,	24),
(9,	25),
(9,	26),
(9,	27),
(9,	28),
(9,	29),
(9,	30),
(7,	31),
(7,	32),
(7,	33),
(7,	34),
(6,	35),
(6,	9),
(6,	36),
(6,	37),
(6,	20),
(6,	38),
(6,	7),
(5,	39),
(5,	9),
(5,	40),
(5,	41),
(5,	42),
(5,	43),
(5,	44),
(4,	45),
(4,	46),
(4,	47),
(4,	48),
(4,	9),
(4,	49),
(3,	50),
(3,	7),
(3,	9),
(3,	51),
(3,	52),
(3,	53),
(3,	54),
(3,	55),
(2,	56),
(2,	57),
(2,	58),
(2,	59),
(2,	60),
(2,	61),
(2,	62),
(1,	8),
(1,	52),
(1,	63),
(1,	9),
(1,	16),
(1,	64),
(1,	65),
(1,	7);

DROP TABLE IF EXISTS "chat_messages";
DROP SEQUENCE IF EXISTS chat_messages_id_seq;
CREATE SEQUENCE chat_messages_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."chat_messages" (
    "id" bigint DEFAULT nextval('chat_messages_id_seq') NOT NULL,
    "session_id" bigint NOT NULL,
    "pengirim" character varying(255) NOT NULL,
    "pesan" text NOT NULL,
    "metadata" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "chat_messages_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "chat_messages_pengirim_check" CHECK ((pengirim)::text = ANY ((ARRAY['pengunjung'::character varying, 'ai'::character varying, 'agen'::character varying])::text[]))
)
WITH (oids = false);


DROP TABLE IF EXISTS "chat_sessions";
DROP SEQUENCE IF EXISTS chat_sessions_id_seq;
CREATE SEQUENCE chat_sessions_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."chat_sessions" (
    "id" bigint DEFAULT nextval('chat_sessions_id_seq') NOT NULL,
    "widget_id" bigint NOT NULL,
    "session_token" character varying(255) NOT NULL,
    "nama_pengunjung" character varying(255),
    "email_pengunjung" character varying(255),
    "ip_pengunjung" character varying(255),
    "user_agent" character varying(255),
    "halaman_url" character varying(255),
    "status" character varying(255) DEFAULT 'aktif' NOT NULL,
    "tiket_id" bigint,
    "aktivitas_terakhir" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "chat_sessions_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "chat_sessions_status_check" CHECK ((status)::text = ANY ((ARRAY['aktif'::character varying, 'selesai'::character varying, 'eskalasi'::character varying])::text[]))
)
WITH (oids = false);

CREATE UNIQUE INDEX chat_sessions_session_token_unique ON public.chat_sessions USING btree (session_token);


DROP TABLE IF EXISTS "chat_widgets";
DROP SEQUENCE IF EXISTS chat_widgets_id_seq;
CREATE SEQUENCE chat_widgets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."chat_widgets" (
    "id" bigint DEFAULT nextval('chat_widgets_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "public_key" character varying(255) NOT NULL,
    "secret_key" character varying(255) NOT NULL,
    "domain" character varying(255),
    "pengaturan" json,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "chat_widgets_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX chat_widgets_public_key_unique ON public.chat_widgets USING btree (public_key);


DROP TABLE IF EXISTS "clients";
DROP SEQUENCE IF EXISTS clients_id_seq;
CREATE SEQUENCE clients_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."clients" (
    "id" bigint DEFAULT nextval('clients_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "country" character varying(2),
    "shop_id" character varying(255),
    "app" character varying(255),
    "plan" character varying(255),
    "phone" character varying(255),
    "status" character varying(255) DEFAULT 'active' NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "clients_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "clients_status_check" CHECK ((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'suspended'::character varying])::text[]))
)
WITH (oids = false);

CREATE UNIQUE INDEX clients_email_unique ON public.clients USING btree (email);


DROP TABLE IF EXISTS "faqs";
DROP SEQUENCE IF EXISTS faqs_id_seq;
CREATE SEQUENCE faqs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."faqs" (
    "id" bigint DEFAULT nextval('faqs_id_seq') NOT NULL,
    "pertanyaan" character varying(255) NOT NULL,
    "jawaban" text NOT NULL,
    "urutan" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "faqs_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "faqs" ("id", "pertanyaan", "jawaban", "urutan", "aktif", "created_at", "updated_at") VALUES
(1,	'How long does prototyping take?',	'Standard rapid prototyping usually takes 3-5 business days depending on complexity.',	1,	't',	NULL,	NULL),
(2,	'Do you offer international shipping?',	'Yes, we ship our custom manufactured parts globally with tracked express delivery.',	2,	't',	NULL,	NULL),
(3,	'What materials do you work with?',	'We work with aerospace-grade aluminum, titanium, various engineering plastics, and carbon fiber.',	3,	't',	NULL,	NULL);

DROP TABLE IF EXISTS "iklan";
DROP SEQUENCE IF EXISTS iklan_id_seq;
CREATE SEQUENCE iklan_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."iklan" (
    "id" bigint DEFAULT nextval('iklan_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "jenis" character varying(255) DEFAULT 'gambar' NOT NULL,
    "konten" text NOT NULL,
    "posisi" character varying(255) NOT NULL,
    "link" character varying(255),
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "iklan_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "iklan_jenis_check" CHECK ((jenis)::text = ANY ((ARRAY['gambar'::character varying, 'script'::character varying])::text[]))
)
WITH (oids = false);

COMMENT ON COLUMN "public"."iklan"."posisi" IS 'header, sidebar, footer, article_middle';


DROP TABLE IF EXISTS "izin";
DROP SEQUENCE IF EXISTS izin_id_seq;
CREATE SEQUENCE izin_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."izin" (
    "id" bigint DEFAULT nextval('izin_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "modul" character varying(255),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "izin_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX izin_nama_unique ON public.izin USING btree (nama);

CREATE UNIQUE INDEX izin_slug_unique ON public.izin USING btree (slug);

INSERT INTO "izin" ("id", "nama", "slug", "modul", "created_at", "updated_at") VALUES
(1,	'Kelola Pengaturan',	'kelola-pengaturan',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(2,	'Kelola Pengguna',	'kelola-pengguna',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(3,	'Kelola Modul',	'kelola-modul',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(4,	'Kelola Tema',	'kelola-tema',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(5,	'Kelola Menu',	'kelola-menu',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(6,	'Kelola Artikel',	'kelola-artikel',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(7,	'Kelola Berita',	'kelola-berita',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(8,	'Kelola Video',	'kelola-video',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(9,	'Kelola Iklan',	'kelola-iklan',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(10,	'Kelola Slideshow',	'kelola-slideshow',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(11,	'Kelola Portofolio',	'kelola-portofolio',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(12,	'Kelola Faq',	'kelola-faq',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(13,	'Kelola Layanan',	'kelola-layanan',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(14,	'Kelola Tiket',	'kelola-tiket',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(15,	'Kelola Task',	'kelola-task',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(16,	'Kelola Kontak',	'kelola-kontak',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(17,	'Kelola Komentar',	'kelola-komentar',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(18,	'Kelola Statistik',	'kelola-statistik',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(19,	'Kelola Knowledgebase',	'kelola-knowledgebase',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06'),
(20,	'Kelola Chat',	'kelola-chat',	NULL,	'2026-01-22 15:27:06',	'2026-01-22 15:27:06');

DROP TABLE IF EXISTS "kata_sandi_reset_token";
CREATE TABLE "public"."kata_sandi_reset_token" (
    "email" character varying(255) NOT NULL,
    "token" character varying(255) NOT NULL,
    "dibuat_pada" timestamp(0),
    CONSTRAINT "kata_sandi_reset_token_pkey" PRIMARY KEY ("email")
)
WITH (oids = false);


DROP TABLE IF EXISTS "kategori_berita";
DROP SEQUENCE IF EXISTS kategori_berita_id_seq;
CREATE SEQUENCE kategori_berita_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kategori_berita" (
    "id" bigint DEFAULT nextval('kategori_berita_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deskripsi" text,
    CONSTRAINT "kategori_berita_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX kategori_berita_nama_unique ON public.kategori_berita USING btree (nama);

CREATE UNIQUE INDEX kategori_berita_slug_unique ON public.kategori_berita USING btree (slug);

INSERT INTO "kategori_berita" ("id", "nama", "slug", "created_at", "updated_at", "deskripsi") VALUES
(4,	'Uploadfly',	'uploadfly',	'2026-01-23 05:09:38',	'2026-01-23 05:11:04',	NULL),
(1,	'Shopify',	'shopify',	'2026-01-22 15:17:23',	'2026-01-23 05:11:11',	NULL),
(2,	'Apps',	'apps',	'2026-01-22 15:17:23',	'2026-01-23 05:11:21',	NULL),
(3,	'Development',	'development',	'2026-01-22 15:17:23',	'2026-01-23 05:11:30',	NULL);

DROP TABLE IF EXISTS "kb_articles";
DROP SEQUENCE IF EXISTS kb_articles_id_seq;
CREATE SEQUENCE kb_articles_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kb_articles" (
    "id" bigint DEFAULT nextval('kb_articles_id_seq') NOT NULL,
    "category_id" bigint NOT NULL,
    "judul" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "konten" text NOT NULL,
    "views" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "urutan" integer DEFAULT '0' NOT NULL,
    "tags" character varying(255),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "kb_articles_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX kb_articles_slug_unique ON public.kb_articles USING btree (slug);

INSERT INTO "kb_articles" ("id", "category_id", "judul", "slug", "konten", "views", "aktif", "urutan", "tags", "created_at", "updated_at") VALUES
(2,	5,	'Uninstallation',	'uninstallation',	'<p><b>How To Uninstall or remove the app?</b><p>To remove the app it''s very simple, please go to the app and select uploadlfy and see a pinned icon on the right top side and click it<br><br>next select uninstall it will remove the app and cancel your subscription<br><br>Uninstallation complete.</p></p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(3,	5,	'Upgrade or Downgrade Plan / Package',	'upgrade-or-downgrade-plan-/-package',	'<p>How To Upgrade or Downgrade Plan / Package:<ol><li>Select the dashboard menu and select your plan upgrade or downgrade</li><li>Select the plan you want to choose</li><li>next, approve it</li><li>all step is done if still does not reflect what you need let us know.</li></ol><p></p></p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(4,	4,	'What is uploadfly',	'what-is-uploadfly',	'<p>Uploadfly is an app that is available for Shopify only at the moment, we will expand this in the future to other platforms such as Etsy, Big Commerce, etc.<br>Uploadfly is the name of the app used to upload any file for the Shopify store, with easy configuration, you can upload multiple files at the same time, or have additional price charges and also conditional logic.<p><br></p></p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(5,	11,	'How to enable the upload button',	'how-to-enable-the-upload-button',	'<p>To enable the upload button for your product there are 3 ways for that: Import from Shopify products, bulk import, and inside the Uploadfly app.<br><br><b>1. Import from Shopify products: </b>Select your product from your Shopify list inside that product select the more action button and choose Uploadfly, it will automatically enable the upload button for your product, and bring you to the inside of the app to set the upload field.<br><br><b>2. Bulk import:</b> For bulk import go to your Shopify product menu and inside the product, we can see all products now select the product that you want to have an upload field.</p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(6,	7,	'General Setting',	'general-setting',	'<p>General settings are used for the default setting of the product, every time adding an upload field to the product it will use the same setting as the general setting.</p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(7,	9,	'Files Order',	'files-order',	'<p>To get the file uploaded by the customer you can go to the Uploadfly app and select files menus. in the files area, we can see all files that have been uploaded by the customer, you can easily download the file by clicking the download icon.</p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(8,	4,	'How to get support',	'how-to-get-support',	'<p>If you have any questions or need help you can go to the support menu inside the app, you can find knowledgebase, articles, news, or FAQ, including the ticket.<p><br></p><p><br></p></p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(9,	4,	'Dashboard Overview',	'dashboard-overview',	'<p>In the dashboard area, you can get information about whether the app is already installed or not, including all details about how many products were added to Uploadfly, the total orders you get, your current plan, and support<p>At the bottom, you will see our latest news, knowledge base, and tutorials.</p></p>',	0,	't',	0,	'',	'2026-01-25 16:03:15',	'2026-01-25 16:03:15'),
(1,	5,	'How to Install the Uploadfly App on Shopify',	'install-uploadfly',	'<p>Installing the Uploadfly application is a straightforward process. This guide provides step-by-step instructions to get the app installed, configured, and ready for use on your Shopify store.</p>

<h3>Installation and Initial Setup</h3>
<p>Please follow these easy steps to complete the installation:</p>

<ol>
    <li><strong>Locate the Uploadfly App:</strong>
        <p>Find the application on the official Shopify App Store. You can search for "Uploadfly" or use the provided link (<em>[Insert App Store Link Here]</em>).</p>
    </li>

    <li><strong>Initiate Installation:</strong>
        <p>On the app page, click the <strong>"Add app"</strong> or <strong>"Install"</strong> button. You will be guided through granting the necessary permissions for Uploadfly to integrate with your Shopify store.</p>
        <ul>
            <li>Review the requested permissions carefully.</li>
            <li>Click <strong>"Install app"</strong> to confirm and proceed.</li>
        </ul>
    </li>

    <li><strong>Select Your Subscription Plan:</strong>
        <p>Following the installation, you will be directed to the subscription page. Select the plan that best suits your store''s operational needs and budget.</p>
    </li>

    <li><strong>Configure Global Settings:</strong>
        <p>Once the plan is selected, you will be taken to the Uploadfly Global Settings dashboard. Here, you can define default behaviors and appearance settings for the app.</p>
        <ul>
            <li>Set up your preferred defaults (e.g., maximum file size, accepted file types, display text).</li>
            <li>Ensure you <strong>Save</strong> these settings. These defaults will apply automatically when you activate the Uploadfly feature on your products.</li>
        </ul>
    </li>

    <li><strong>Enable the Upload Button on Products:</strong>
        <p>The final step is to activate the upload functionality on specific products. To do this:</p>
        <p>Go to your Shopify <strong>Product List</strong> and select the product you wish to edit. Within the product editor, locate the Uploadfly settings section and enable the upload button for that product.</p>
    </li>
</ol>

<h3>Installation Complete!</h3>
<p>You have successfully installed and configured the Uploadfly app. If you encounter any issues during this process or have additional questions regarding configuration, please do not hesitate to reach out to our support team. We are always happy to help you!</p>',	0,	't',	0,	'shopify, uploadfly, installation, setup, guide, technical-documentation',	'2026-01-25 16:03:15',	'2026-01-25 16:26:24');

DROP TABLE IF EXISTS "kb_categories";
DROP SEQUENCE IF EXISTS kb_categories_id_seq;
CREATE SEQUENCE kb_categories_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kb_categories" (
    "id" bigint DEFAULT nextval('kb_categories_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "ikon" character varying(255),
    "deskripsi" text,
    "urutan" integer DEFAULT '0' NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "parent_id" bigint,
    CONSTRAINT "kb_categories_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX kb_categories_slug_unique ON public.kb_categories USING btree (slug);

INSERT INTO "kb_categories" ("id", "nama", "slug", "ikon", "deskripsi", "urutan", "created_at", "updated_at", "parent_id") VALUES
(1,	'Uploadfly',	'uploadfly',	'fas fa-cloud',	'Uplaodfly Shopify App',	1,	'2026-01-25 15:48:26',	'2026-01-25 15:48:26',	NULL),
(2,	'Pricify',	'pricify',	'fas fa-camera',	'Pricify App Shopify',	2,	'2026-01-25 15:53:10',	'2026-01-25 15:53:30',	NULL),
(3,	'Customfly',	'customfly',	'fas fa-paintbrush',	'Customfly App Shopify',	3,	'2026-01-25 15:54:14',	'2026-01-25 15:54:14',	NULL),
(4,	'General',	'general',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(5,	'Installation',	'installation',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(6,	'Bug',	'bug',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(7,	'Setting',	'setting',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(8,	'How To',	'how-to',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(9,	'Order',	'order',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(10,	'Subscription',	'subscription',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(11,	'Product',	'product',	'fas fa-folder',	'',	0,	'2026-01-25 16:03:15',	'2026-01-25 16:03:15',	1),
(12,	'News',	'news',	'fas fa-folder',	NULL,	0,	'2026-01-25 16:03:15',	'2026-01-25 16:06:48',	1);

DROP TABLE IF EXISTS "komentar";
DROP SEQUENCE IF EXISTS komentar_id_seq;
CREATE SEQUENCE komentar_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."komentar" (
    "id" bigint DEFAULT nextval('komentar_id_seq') NOT NULL,
    "komentabel_type" character varying(255) NOT NULL,
    "komentabel_id" bigint NOT NULL,
    "user_id" bigint,
    "nama" character varying(255),
    "email" character varying(255),
    "isi" text NOT NULL,
    "status" character varying(255) DEFAULT 'pending' NOT NULL,
    "ip_address" character varying(255),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "komentar_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "komentar_status_check" CHECK ((status)::text = ANY ((ARRAY['pending'::character varying, 'disetujui'::character varying, 'spam'::character varying])::text[]))
)
WITH (oids = false);

CREATE INDEX komentar_komentabel_type_komentabel_id_index ON public.komentar USING btree (komentabel_type, komentabel_id);


DROP TABLE IF EXISTS "kontak";
DROP SEQUENCE IF EXISTS kontak_id_seq;
CREATE SEQUENCE kontak_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."kontak" (
    "id" bigint DEFAULT nextval('kontak_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "perihal" character varying(255),
    "pesan" text NOT NULL,
    "status" character varying(255) DEFAULT 'belum_dibaca' NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "kontak_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "kontak_status_check" CHECK ((status)::text = ANY ((ARRAY['belum_dibaca'::character varying, 'sudah_dibaca'::character varying])::text[]))
)
WITH (oids = false);


DROP TABLE IF EXISTS "layanans";
DROP SEQUENCE IF EXISTS layanans_id_seq;
CREATE SEQUENCE layanans_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."layanans" (
    "id" bigint DEFAULT nextval('layanans_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "deskripsi" text,
    "ikon" character varying(255),
    "urutan" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "layanans_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "layanans" ("id", "judul", "deskripsi", "ikon", "urutan", "aktif", "created_at", "updated_at") VALUES
(1,	'Prototyping',	'Rapid iterative design using 3D printing and precision CNC machining.',	'cube',	1,	't',	'2026-01-22 23:54:09',	'2026-01-22 23:54:09'),
(2,	'Smart Batching',	'Optimized small-to-mid scale manufacturing with intelligent supply chains.',	'cogs',	2,	't',	'2026-01-22 23:54:09',	'2026-01-22 23:54:09'),
(3,	'Laser Precision',	'Ultra-accurate laser cutting and engraving for complex geometries.',	'crosshairs',	3,	't',	'2026-01-22 23:54:09',	'2026-01-22 23:54:09');

DROP TABLE IF EXISTS "menus";
DROP SEQUENCE IF EXISTS menus_id_seq;
CREATE SEQUENCE menus_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."menus" (
    "id" bigint DEFAULT nextval('menus_id_seq') NOT NULL,
    "label" character varying(255) NOT NULL,
    "url" character varying(255) NOT NULL,
    "urutan" integer DEFAULT '0' NOT NULL,
    "parent_id" bigint,
    "target" character varying(255) DEFAULT '_self' NOT NULL,
    "posisi" character varying(255) DEFAULT 'header' NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "menus_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "menus" ("id", "label", "url", "urutan", "parent_id", "target", "posisi", "created_at", "updated_at") VALUES
(10,	'Tentang Kami',	'/tentang-kami',	1,	NULL,	'_self',	'footer',	'2026-01-22 15:17:23',	'2026-01-22 15:17:23'),
(11,	'Redaksi',	'/redaksi',	2,	NULL,	'_self',	'footer',	'2026-01-22 15:17:23',	'2026-01-22 15:17:23'),
(12,	'Kebijakan Privasi',	'/kebijakan-privasi',	3,	NULL,	'_self',	'footer',	'2026-01-22 15:17:23',	'2026-01-22 15:17:23'),
(13,	'Syarat & Ketentuan',	'/syarat-ketentuan',	4,	NULL,	'_self',	'footer',	'2026-01-22 15:17:23',	'2026-01-22 15:17:23'),
(14,	'Documentation',	'#',	1,	NULL,	'_self',	'support',	NULL,	NULL),
(15,	'Privacy Policy',	'/privacy.html',	2,	NULL,	'_self',	'support',	NULL,	NULL),
(16,	'Home',	'/',	1,	NULL,	'_self',	'header',	NULL,	NULL),
(17,	'Services',	'/#features',	2,	NULL,	'_self',	'header',	NULL,	NULL),
(18,	'Showcase',	'/portofolio',	3,	NULL,	'_self',	'header',	NULL,	NULL),
(19,	'About',	'/tentang-kami',	4,	NULL,	'_self',	'header',	NULL,	NULL),
(20,	'Contact',	'/kontak',	5,	NULL,	'_self',	'header',	NULL,	NULL);

DROP TABLE IF EXISTS "migrations";
DROP SEQUENCE IF EXISTS migrations_id_seq;
CREATE SEQUENCE migrations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."migrations" (
    "id" integer DEFAULT nextval('migrations_id_seq') NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" integer NOT NULL,
    CONSTRAINT "migrations_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1,	'2024_01_01_000000_core_migration',	1),
(2,	'2026_01_19_100500_seed_video_modul',	1),
(3,	'2026_01_22_000000_create_chat_widgets_table',	2),
(4,	'2026_01_22_000000_create_layanans_table',	3),
(5,	'2024_01_18_000000_buat_tabel_berita',	4),
(6,	'2024_01_18_000001_buat_tabel_kategori_berita',	4),
(7,	'2024_01_18_000002_buat_tabel_pivot_berita_kategori',	4),
(8,	'2024_01_18_000003_tambah_gambar_dan_unggulan_berita',	4),
(9,	'2024_01_18_000004_buat_tabel_tags_berita',	4),
(10,	'2026_01_22_000000_create_portofolios_table',	5),
(11,	'2026_01_22_000001_add_tags_to_portofolios_table',	5),
(12,	'2024_01_18_000000_buat_tabel_menu',	6),
(13,	'2026_01_19_110000_seed_sample_menu',	6),
(14,	'2026_01_19_110500_ensure_menu_module_active',	6),
(15,	'2026_01_22_000000_create_slideshow_table',	7),
(16,	'2026_01_22_000001_add_badges_to_slideshow_table',	7),
(17,	'2026_01_22_000000_create_tikets_table',	8),
(18,	'2024_01_01_000000_buat_tabel_artikel',	9),
(19,	'2024_01_18_000000_buat_tabel_artikel',	9),
(20,	'2026_01_22_000001_create_chat_sessions_table',	10),
(21,	'2026_01_22_000002_create_chat_messages_table',	10),
(22,	'2026_01_19_100000_buat_tabel_video',	11),
(23,	'2026_01_19_103000_tambah_kolom_unggulan_video',	11),
(24,	'2026_01_19_122500_seed_footer_menus',	11),
(25,	'2026_01_19_123000_fix_kategori_slugs',	11),
(26,	'2026_01_19_124000_seed_sample_news_data',	11),
(27,	'2026_01_20_080000_tambah_slug_ke_video',	11),
(28,	'2026_01_22_000005_add_gambar_to_artikel_table',	11),
(29,	'2026_01_22_000000_create_kb_tables',	12),
(30,	'2024_01_18_000000_buat_tabel_kontak',	13),
(31,	'2026_01_22_000000_create_faqs_table',	14),
(32,	'2026_01_22_000000_create_tasks_table',	15),
(33,	'2026_01_18_000000_buat_tabel_iklan',	16),
(34,	'2024_01_18_000000_buat_tabel_komentar',	17),
(35,	'2024_01_18_000000_buat_tabel_statistik',	18),
(36,	'2024_01_18_000001_tambah_negara_statistik',	18),
(37,	'2026_01_25_000000_add_parent_id_to_kb_categories',	19),
(38,	'2026_01_25_012423_add_deskripsi_to_kategori_berita_table',	19),
(39,	'2026_01_25_000000_create_tiket_categories_table',	20),
(40,	'2026_01_26_022513_create_clients_table',	21);

DROP TABLE IF EXISTS "modul";
DROP SEQUENCE IF EXISTS modul_id_seq;
CREATE SEQUENCE modul_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."modul" (
    "id" bigint DEFAULT nextval('modul_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "versi" character varying(255) NOT NULL,
    "deskripsi" text,
    "aktif" boolean DEFAULT false NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "modul_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX modul_slug_unique ON public.modul USING btree (slug);

INSERT INTO "modul" ("id", "nama", "slug", "versi", "deskripsi", "aktif", "created_at", "updated_at") VALUES
(1,	'Video',	'video',	'1.0.0',	'Modul pengelolaan video Youtube.',	't',	'2026-01-22 11:42:12',	'2026-01-22 11:42:12'),
(2,	'Manajemen Menu',	'menu',	'1.0.0',	'Modul untuk mengelola navigasi menu pada website.',	't',	'2026-01-22 11:42:45',	'2026-01-22 11:42:45'),
(3,	'Knowledge Base',	'Knowledgebase',	'1.0.0',	'Modul untuk mengelola basis pengetahuan, panduan, dan dokumentasi bantuan.',	't',	'2026-01-22 16:24:30',	'2026-01-22 16:24:30'),
(4,	'Pesan Kontak',	'Kontak',	'1.0.0',	'Modul untuk menerima dan mengelola pesan dari formulir kontak pengunjung.',	't',	'2026-01-22 16:24:36',	'2026-01-22 16:24:36'),
(5,	'Layanan',	'Layanan',	'1.0.0',	'Modul untuk mengelola layanan perusahaan.',	't',	'2026-01-22 16:24:42',	'2026-01-22 16:24:42'),
(6,	'Manajemen Pengguna',	'Pengguna',	'1.0.0',	'Modul untuk mengelola akun pengguna dan hak akses.',	't',	'2026-01-22 16:24:49',	'2026-01-22 16:24:49'),
(7,	'Portofolio',	'Portofolio',	'1.0.0',	'Modul untuk mengelola portofolio proyek atau hasil kerja.',	't',	'2026-01-22 16:24:52',	'2026-01-22 16:24:52'),
(8,	'Slideshow',	'Slideshow',	'1.0.0',	'Modul pengelolaan slideshow untuk halaman utama.',	't',	'2026-01-22 16:24:55',	'2026-01-22 16:24:55'),
(9,	'Task Management',	'Task',	'1.0.0',	'Modular Task Management System',	't',	'2026-01-22 16:24:58',	'2026-01-22 16:24:58'),
(10,	'Ticketing System',	'Tiket',	'1.0.0',	'Modul untuk mengelola tiket dukungan pelanggan dan bantuan teknis.',	't',	'2026-01-22 16:25:00',	'2026-01-22 16:25:00'),
(11,	'Chat',	'Chat',	'1.0.0',	'',	't',	'2026-01-22 16:25:06',	'2026-01-22 16:25:06'),
(12,	'FAQ',	'Faq',	'1.0.0',	'Modul untuk mengelola pertanyaan yang sering diajukan (FAQ).',	't',	'2026-01-22 16:25:09',	'2026-01-22 16:25:09'),
(13,	'Berita',	'Berita',	'1.0.0',	'Modul pengelolaan berita terkini dan pengumuman.',	't',	'2026-01-23 05:08:47',	'2026-01-23 05:08:47');

DROP TABLE IF EXISTS "pengaturan";
DROP SEQUENCE IF EXISTS pengaturan_id_seq;
CREATE SEQUENCE pengaturan_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."pengaturan" (
    "id" bigint DEFAULT nextval('pengaturan_id_seq') NOT NULL,
    "kunci" character varying(255) NOT NULL,
    "nilai" text,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "pengaturan_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX pengaturan_kunci_unique ON public.pengaturan USING btree (kunci);

INSERT INTO "pengaturan" ("id", "kunci", "nilai", "created_at", "updated_at") VALUES
(4,	'facebook',	'#',	NULL,	NULL),
(5,	'twitter',	'#',	NULL,	NULL),
(6,	'linkedin',	'#',	NULL,	NULL),
(7,	'instagram',	'#',	NULL,	NULL),
(8,	'whatsapp',	'628123456789',	NULL,	NULL),
(10,	'chat_widget_url',	'https://help.imakecustom.com/app-assets/chat_js',	NULL,	NULL),
(1,	'nama_situs',	'iMakeCustom',	'2026-01-22 11:43:01',	'2026-01-23 05:18:21'),
(2,	'deskripsi_situs',	'Redefining custom manufacturing through innovation and precision.',	NULL,	'2026-01-23 05:18:21'),
(3,	'email_admin',	'hello@imakecustom.com',	NULL,	'2026-01-23 05:18:21'),
(9,	'alamat',	'Silicon Valley, CA',	NULL,	'2026-01-23 05:18:21'),
(11,	'sosmed_facebook',	'https://facebook.com/imakecustom',	NULL,	'2026-01-23 05:18:21'),
(12,	'sosmed_twitter',	'#',	NULL,	'2026-01-23 05:18:21'),
(13,	'sosmed_instagram',	'#',	NULL,	'2026-01-23 05:18:21'),
(14,	'sosmed_linkedin',	'#',	NULL,	'2026-01-23 05:18:21'),
(15,	'sosmed_youtube',	'#',	NULL,	'2026-01-23 05:18:21'),
(16,	'optimasi_redis_aktif',	'0',	NULL,	'2026-01-23 05:18:21'),
(17,	'optimasi_redis_host',	'127.0.0.1',	NULL,	'2026-01-23 05:18:21'),
(18,	'optimasi_redis_port',	'6379',	NULL,	'2026-01-23 05:18:21'),
(19,	'optimasi_redis_password',	'password123',	NULL,	'2026-01-23 05:18:21'),
(20,	'optimasi_webp_aktif',	'0',	NULL,	'2026-01-23 05:18:21'),
(21,	'optimasi_webp_kualitas',	'80',	NULL,	'2026-01-23 05:18:21'),
(36,	'ai_gemini_key',	'AIzaSyD-47DiKtmcbzu7PGtV06HrY6320O4Fj20',	NULL,	'2026-01-23 05:18:21'),
(22,	'mail_driver',	'smtp',	NULL,	'2026-01-23 05:18:21'),
(23,	'mail_host',	NULL,	NULL,	'2026-01-23 05:18:21'),
(24,	'mail_port',	'587',	NULL,	'2026-01-23 05:18:21'),
(25,	'mail_username',	NULL,	NULL,	'2026-01-23 05:18:21'),
(26,	'mail_password',	NULL,	NULL,	'2026-01-23 05:18:21'),
(27,	'mail_encryption',	NULL,	NULL,	'2026-01-23 05:18:21'),
(28,	'mail_from_address',	NULL,	NULL,	'2026-01-23 05:18:21'),
(29,	'mail_from_name',	NULL,	NULL,	'2026-01-23 05:18:21'),
(30,	'captcha_aktif',	'0',	NULL,	'2026-01-23 05:18:21'),
(31,	'captcha_site_key',	NULL,	NULL,	'2026-01-23 05:18:21'),
(32,	'captcha_secret_key',	NULL,	NULL,	'2026-01-23 05:18:21'),
(33,	'backup_otomatis',	'0',	NULL,	'2026-01-23 05:18:21'),
(34,	'backup_simpan_server',	'1',	NULL,	'2026-01-23 05:18:21'),
(35,	'backup_email',	NULL,	NULL,	'2026-01-23 05:18:21'),
(37,	'ai_gemini_model',	'gemini-flash-latest',	NULL,	'2026-01-23 05:18:21');

DROP TABLE IF EXISTS "pengguna";
DROP SEQUENCE IF EXISTS pengguna_id_seq;
CREATE SEQUENCE pengguna_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."pengguna" (
    "id" bigint DEFAULT nextval('pengguna_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "email_diverifikasi_pada" timestamp(0),
    "kata_sandi" character varying(255) NOT NULL,
    "remember_token" character varying(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "pengguna_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX pengguna_email_unique ON public.pengguna USING btree (email);

INSERT INTO "pengguna" ("id", "nama", "email", "email_diverifikasi_pada", "kata_sandi", "remember_token", "created_at", "updated_at") VALUES
(1,	'Admin',	'admin@imakecustom.com',	NULL,	'$2y$12$Cbq.6aWNpjKVeQInn.fG8O4Ivb4yfib/RLyCySqiQy37hTlHwgX8K',	NULL,	'2026-01-22 13:40:13',	'2026-01-22 13:40:13');

DROP TABLE IF EXISTS "pengguna_peran";
CREATE TABLE "public"."pengguna_peran" (
    "pengguna_id" bigint NOT NULL,
    "peran_id" bigint NOT NULL,
    CONSTRAINT "pengguna_peran_pkey" PRIMARY KEY ("pengguna_id", "peran_id")
)
WITH (oids = false);

INSERT INTO "pengguna_peran" ("pengguna_id", "peran_id") VALUES
(1,	1);

DROP TABLE IF EXISTS "peran";
DROP SEQUENCE IF EXISTS peran_id_seq;
CREATE SEQUENCE peran_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."peran" (
    "id" bigint DEFAULT nextval('peran_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "peran_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX peran_nama_unique ON public.peran USING btree (nama);

CREATE UNIQUE INDEX peran_slug_unique ON public.peran USING btree (slug);

INSERT INTO "peran" ("id", "nama", "slug", "created_at", "updated_at") VALUES
(1,	'Administrator',	'administrator',	'2026-01-22 15:27:06',	'2026-01-22 15:27:06');

DROP TABLE IF EXISTS "peran_izin";
CREATE TABLE "public"."peran_izin" (
    "peran_id" bigint NOT NULL,
    "izin_id" bigint NOT NULL,
    CONSTRAINT "peran_izin_pkey" PRIMARY KEY ("peran_id", "izin_id")
)
WITH (oids = false);

INSERT INTO "peran_izin" ("peran_id", "izin_id") VALUES
(1,	1),
(1,	2),
(1,	3),
(1,	4),
(1,	5),
(1,	6),
(1,	7),
(1,	8),
(1,	9),
(1,	10),
(1,	11),
(1,	12),
(1,	13),
(1,	14),
(1,	15),
(1,	16),
(1,	17),
(1,	18),
(1,	19),
(1,	20);

DROP TABLE IF EXISTS "portofolios";
DROP SEQUENCE IF EXISTS portofolios_id_seq;
CREATE SEQUENCE portofolios_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."portofolios" (
    "id" bigint DEFAULT nextval('portofolios_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "kategori" character varying(255),
    "klien" character varying(255),
    "gambar" character varying(255) NOT NULL,
    "deskripsi" text,
    "url" character varying(255),
    "tanggal" date,
    "urutan" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "tags" text,
    CONSTRAINT "portofolios_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX portofolios_slug_unique ON public.portofolios USING btree (slug);

INSERT INTO "portofolios" ("id", "judul", "slug", "kategori", "klien", "gambar", "deskripsi", "url", "tanggal", "urutan", "aktif", "created_at", "updated_at", "tags") VALUES
(1,	'Cyber-Sleeves',	'cyber-sleeves',	'Design',	NULL,	'portfolio/cyber-sleeves.jpg',	'Aerospace-grade custom housing',	NULL,	NULL,	1,	't',	'2026-01-23 00:01:38',	'2026-01-23 00:01:38',	'Design,Tech'),
(2,	'Nexus Artic',	'nexus-artic',	'Print',	NULL,	'portfolio/nexus-artic.jpg',	'Custom robotics exoskeleton',	NULL,	NULL,	2,	't',	'2026-01-23 00:01:38',	'2026-01-23 00:01:38',	'Robotics,Future'),
(3,	'Aero-Dynamics',	'aero-dynamics',	'Design',	NULL,	'portfolio/aero-dynamics.jpg',	'Wind-tunnel tested custom parts',	NULL,	NULL,	3,	't',	'2026-01-23 00:01:38',	'2026-01-23 00:01:38',	'Print,Aero');

DROP TABLE IF EXISTS "sesi";
CREATE TABLE "public"."sesi" (
    "id" character varying(255) NOT NULL,
    "user_id" bigint,
    "ip_address" character varying(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" integer NOT NULL,
    CONSTRAINT "sesi_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX sesi_user_id_index ON public.sesi USING btree (user_id);

CREATE INDEX sesi_last_activity_index ON public.sesi USING btree (last_activity);


DROP TABLE IF EXISTS "singgahan";
CREATE TABLE "public"."singgahan" (
    "key" character varying(255) NOT NULL,
    "value" text NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "singgahan_pkey" PRIMARY KEY ("key")
)
WITH (oids = false);


DROP TABLE IF EXISTS "singgahan_locks";
CREATE TABLE "public"."singgahan_locks" (
    "key" character varying(255) NOT NULL,
    "owner" character varying(255) NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "singgahan_locks_pkey" PRIMARY KEY ("key")
)
WITH (oids = false);


DROP TABLE IF EXISTS "slideshow";
DROP SEQUENCE IF EXISTS slideshow_id_seq;
CREATE SEQUENCE slideshow_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."slideshow" (
    "id" bigint DEFAULT nextval('slideshow_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "deskripsi" character varying(255),
    "gambar" character varying(255) NOT NULL,
    "url" character varying(255),
    "urutan" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "badge_1" character varying(255),
    "badge_2" character varying(255),
    CONSTRAINT "slideshow_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

INSERT INTO "slideshow" ("id", "judul", "deskripsi", "gambar", "url", "urutan", "aktif", "created_at", "updated_at", "badge_1", "badge_2") VALUES
(1,	'Where Vision Meets <span>Precision</span>',	'Turn your boldest concepts into reality with our state-of-the-art custom manufacturing platform. From rapid prototyping to full-scale production.',	'hero-slide.png',	'#contact',	1,	't',	'2026-01-22 23:50:30',	'2026-01-22 23:50:30',	'Start Your Project',	'View Showcase');

DROP TABLE IF EXISTS "stat_pengunjung";
DROP SEQUENCE IF EXISTS stat_pengunjung_id_seq;
CREATE SEQUENCE stat_pengunjung_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."stat_pengunjung" (
    "id" bigint DEFAULT nextval('stat_pengunjung_id_seq') NOT NULL,
    "ip" character varying(255) NOT NULL,
    "perangkat" character varying(255),
    "url" character varying(255),
    "referensi" character varying(255),
    "tanggal" date NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "negara" character varying(255),
    "kode_negara" character varying(5),
    CONSTRAINT "stat_pengunjung_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX stat_pengunjung_ip_index ON public.stat_pengunjung USING btree (ip);

CREATE INDEX stat_pengunjung_tanggal_index ON public.stat_pengunjung USING btree (tanggal);


DROP TABLE IF EXISTS "tag_berita";
DROP SEQUENCE IF EXISTS tag_berita_id_seq;
CREATE SEQUENCE tag_berita_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tag_berita" (
    "id" bigint DEFAULT nextval('tag_berita_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "tag_berita_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX tag_berita_nama_unique ON public.tag_berita USING btree (nama);

CREATE UNIQUE INDEX tag_berita_slug_unique ON public.tag_berita USING btree (slug);

INSERT INTO "tag_berita" ("id", "nama", "slug", "created_at", "updated_at") VALUES
(1,	'shopify file uploader',	'shopify-file-uploader',	'2026-01-23 05:40:06',	'2026-01-23 05:40:06'),
(2,	'aplikasi shopify terbaik',	'aplikasi-shopify-terbaik',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(3,	'upload multi-file',	'upload-multi-file',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(4,	'logika kondisional shopify',	'logika-kondisional-shopify',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(5,	'harga tambahan produk',	'harga-tambahan-produk',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(6,	'e-commerce file upload',	'e-commerce-file-upload',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(7,	'uploadfly',	'uploadfly',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(8,	'shopify app',	'shopify-app',	'2026-01-23 05:40:07',	'2026-01-23 05:40:07'),
(9,	'custom products',	'custom-products',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(10,	'personalized gifts',	'personalized-gifts',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(11,	'Shopify trends 2025',	'shopify-trends-2025',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(12,	'e-commerce ideas',	'e-commerce-ideas',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(13,	'trending products',	'trending-products',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(14,	'custom AI art',	'custom-ai-art',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(15,	'pet portrait gifts',	'pet-portrait-gifts',	'2026-01-23 06:22:45',	'2026-01-23 06:22:45'),
(16,	'Print on Demand',	'print-on-demand',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(17,	'POD',	'pod',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(18,	'Cetak Sendiri',	'cetak-sendiri',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(19,	'E-commerce Strategy',	'e-commerce-strategy',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(20,	'Profit Margins',	'profit-margins',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(21,	'Scalability',	'scalability',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(22,	'Startup Costs',	'startup-costs',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(23,	'Bisnis Kustom',	'bisnis-kustom',	'2026-01-23 06:23:05',	'2026-01-23 06:23:05'),
(24,	'Shopify file uploader app',	'shopify-file-uploader-app',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(25,	'conditional logic',	'conditional-logic',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(26,	'dynamic pricing',	'dynamic-pricing',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(27,	'custom product builder',	'custom-product-builder',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(28,	'multi-file uploads',	'multi-file-uploads',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(29,	'e-commerce customization',	'e-commerce-customization',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(30,	'best Shopify app',	'best-shopify-app',	'2026-01-23 06:35:54',	'2026-01-23 06:35:54'),
(31,	'shopify fulfillment',	'shopify-fulfillment',	'2026-01-23 06:42:59',	'2026-01-23 06:42:59'),
(32,	'in-house printing',	'in-house-printing',	'2026-01-23 06:42:59',	'2026-01-23 06:42:59'),
(33,	'DTC strategy',	'dtc-strategy',	'2026-01-23 06:42:59',	'2026-01-23 06:42:59'),
(34,	'e-commerce scalability',	'e-commerce-scalability',	'2026-01-23 06:42:59',	'2026-01-23 06:42:59'),
(35,	'shopify',	'shopify',	'2026-01-23 06:43:40',	'2026-01-23 06:43:40'),
(36,	'product personalization',	'product-personalization',	'2026-01-23 06:43:40',	'2026-01-23 06:43:40'),
(37,	'e-commerce growth',	'e-commerce-growth',	'2026-01-23 06:43:40',	'2026-01-23 06:43:40'),
(38,	'customer loyalty',	'customer-loyalty',	'2026-01-23 06:43:40',	'2026-01-23 06:43:40'),
(39,	'Shopify sales strategy',	'shopify-sales-strategy',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(40,	'e-commerce personalization',	'e-commerce-personalization',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(41,	'conversion rate optimization',	'conversion-rate-optimization',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(42,	'UGC',	'ugc',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(43,	'Shopify marketing',	'shopify-marketing',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(44,	'sales growth',	'sales-growth',	'2026-01-23 06:48:07',	'2026-01-23 06:48:07'),
(45,	'Shopify Guide',	'shopify-guide',	'2026-01-23 06:50:08',	'2026-01-23 06:50:08'),
(46,	'E-commerce Beginners',	'e-commerce-beginners',	'2026-01-23 06:50:08',	'2026-01-23 06:50:08'),
(47,	'Start Online Store',	'start-online-store',	'2026-01-23 06:50:08',	'2026-01-23 06:50:08'),
(48,	'Shopify Tutorial 2025',	'shopify-tutorial-2025',	'2026-01-23 06:50:08',	'2026-01-23 06:50:08'),
(49,	'SEO',	'seo',	'2026-01-23 06:50:08',	'2026-01-23 06:50:08'),
(50,	'Shopify store',	'shopify-store',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(51,	'free app access',	'free-app-access',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(52,	'file uploader',	'file-uploader',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(53,	'personalized products',	'personalized-products',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(54,	'ecommerce optimization',	'ecommerce-optimization',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(55,	'new merchant offer',	'new-merchant-offer',	'2026-01-23 08:03:29',	'2026-01-23 08:03:29'),
(56,	'Shopify Themes',	'shopify-themes',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(57,	'E-commerce CRO',	'e-commerce-cro',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(58,	'Boost Sales',	'boost-sales',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(59,	'Mobile Responsive Design',	'mobile-responsive-design',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(60,	'Best Shopify Themes 2024',	'best-shopify-themes-2024',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(61,	'Shopify Conversion Rate Optimization',	'shopify-conversion-rate-optimization',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(62,	'UX/UI',	'uxui',	'2026-01-24 03:17:52',	'2026-01-24 03:17:52'),
(63,	'Free Shopify App',	'free-shopify-app',	'2026-01-24 03:18:31',	'2026-01-24 03:18:31'),
(64,	'Order Management',	'order-management',	'2026-01-24 03:18:31',	'2026-01-24 03:18:31'),
(65,	'Ecommerce Tools',	'ecommerce-tools',	'2026-01-24 03:18:31',	'2026-01-24 03:18:31');

DROP TABLE IF EXISTS "task_activities";
DROP SEQUENCE IF EXISTS task_activities_id_seq;
CREATE SEQUENCE task_activities_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."task_activities" (
    "id" bigint DEFAULT nextval('task_activities_id_seq') NOT NULL,
    "task_id" bigint NOT NULL,
    "user_id" bigint,
    "action" character varying(255) NOT NULL,
    "details" text,
    "changes" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "task_activities_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "tasks";
DROP SEQUENCE IF EXISTS tasks_id_seq;
CREATE SEQUENCE tasks_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tasks" (
    "id" bigint DEFAULT nextval('tasks_id_seq') NOT NULL,
    "uuid" uuid NOT NULL,
    "title" character varying(255) NOT NULL,
    "description" text,
    "status" character varying(255) DEFAULT 'pending' NOT NULL,
    "priority" character varying(255) DEFAULT 'medium' NOT NULL,
    "assigned_to" bigint,
    "created_by" bigint,
    "team_id" bigint,
    "tiket_id" bigint,
    "chat_session_id" integer,
    "parent_task_id" bigint,
    "due_at" timestamp(0),
    "sla_at" timestamp(0),
    "started_at" timestamp(0),
    "completed_at" timestamp(0),
    "is_ai_generated" boolean DEFAULT false NOT NULL,
    "ai_metadata" json,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp(0),
    CONSTRAINT "tasks_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "tasks_status_check" CHECK ((status)::text = ANY ((ARRAY['pending'::character varying, 'in_progress'::character varying, 'blocked'::character varying, 'review'::character varying, 'done'::character varying, 'cancelled'::character varying])::text[])),
    CONSTRAINT "tasks_priority_check" CHECK ((priority)::text = ANY ((ARRAY['low'::character varying, 'medium'::character varying, 'high'::character varying, 'urgent'::character varying])::text[]))
)
WITH (oids = false);

CREATE UNIQUE INDEX tasks_uuid_unique ON public.tasks USING btree (uuid);

CREATE INDEX tasks_status_index ON public.tasks USING btree (status);

CREATE INDEX tasks_priority_index ON public.tasks USING btree (priority);

CREATE INDEX tasks_chat_session_id_index ON public.tasks USING btree (chat_session_id);

INSERT INTO "tasks" ("id", "uuid", "title", "description", "status", "priority", "assigned_to", "created_by", "team_id", "tiket_id", "chat_session_id", "parent_task_id", "due_at", "sla_at", "started_at", "completed_at", "is_ai_generated", "ai_metadata", "created_at", "updated_at", "deleted_at") VALUES
(1,	'a3973ed7-04d8-4c4f-a250-fa9d0bc02d04',	'Imakecustom',	NULL,	'pending',	'medium',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'f',	NULL,	'2026-01-23 09:44:01',	'2026-01-23 09:44:01',	NULL),
(2,	'b204ad5a-664b-424a-9569-372ade51d7d4',	'ts',	NULL,	'pending',	'medium',	NULL,	1,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'f',	NULL,	'2026-01-23 14:26:18',	'2026-01-23 14:26:18',	NULL),
(3,	'5e336cd2-7274-4d23-a115-d5ac675febe9',	'test',	NULL,	'pending',	'medium',	NULL,	1,	NULL,	NULL,	NULL,	2,	NULL,	NULL,	NULL,	NULL,	'f',	NULL,	'2026-01-23 14:26:26',	'2026-01-23 14:26:26',	NULL);

DROP TABLE IF EXISTS "tema";
DROP SEQUENCE IF EXISTS tema_id_seq;
CREATE SEQUENCE tema_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tema" (
    "id" bigint DEFAULT nextval('tema_id_seq') NOT NULL,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "versi" character varying(255) NOT NULL,
    "aktif" boolean DEFAULT false NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "tema_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX tema_slug_unique ON public.tema USING btree (slug);

INSERT INTO "tema" ("id", "nama", "slug", "versi", "aktif", "created_at", "updated_at") VALUES
(2,	'readora',	'readora',	'1.0.0',	'f',	'2026-01-25 23:33:18',	'2026-01-25 23:33:18'),
(1,	'imakecustom',	'imakecustom',	'1.0.0',	't',	'2026-01-26 14:02:44',	'2026-01-26 14:02:44');

DROP TABLE IF EXISTS "tiket_categories";
DROP SEQUENCE IF EXISTS tiket_categories_id_seq;
CREATE SEQUENCE tiket_categories_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tiket_categories" (
    "id" bigint DEFAULT nextval('tiket_categories_id_seq') NOT NULL,
    "parent_id" bigint,
    "nama" character varying(255) NOT NULL,
    "slug" character varying(255) NOT NULL,
    "deskripsi" text,
    "urutan" integer DEFAULT '0' NOT NULL,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "tiket_categories_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX tiket_categories_slug_unique ON public.tiket_categories USING btree (slug);

INSERT INTO "tiket_categories" ("id", "parent_id", "nama", "slug", "deskripsi", "urutan", "aktif", "created_at", "updated_at") VALUES
(1,	NULL,	'Uploadfly',	'uploadfly',	NULL,	1,	't',	'2026-01-26 00:26:47',	'2026-01-26 00:26:47'),
(2,	1,	'IMCST',	'imcst',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(3,	1,	'Amazonify',	'amazonify',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(4,	1,	'General',	'general',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(5,	1,	'Installation',	'installation',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(6,	1,	'Bug',	'bug',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(7,	1,	'Setting',	'setting',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(8,	1,	'How To',	'how-to',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(9,	1,	'Order',	'order',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(10,	1,	'Subscription',	'subscription',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(11,	1,	'Product',	'product',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(12,	1,	'FAQ',	'faq',	NULL,	0,	'f',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(13,	1,	'App Enhancement',	'app-enhancement',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(14,	1,	'FAQ',	'faq-15',	NULL,	0,	'f',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(15,	1,	'News',	'news',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(16,	2,	'Req Template',	'req-template',	NULL,	0,	't',	'2026-01-26 00:29:30',	'2026-01-26 00:29:30'),
(17,	NULL,	'Pricify',	'pricify',	'Pricify App Support',	2,	't',	'2026-01-26 00:30:58',	'2026-01-26 00:30:58'),
(18,	NULL,	'Customfly',	'customfly',	'Customfly App Support',	3,	't',	'2026-01-26 00:31:10',	'2026-01-26 00:31:10');

DROP TABLE IF EXISTS "tiket_pesans";
DROP SEQUENCE IF EXISTS tiket_pesans_id_seq;
CREATE SEQUENCE tiket_pesans_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tiket_pesans" (
    "id" bigint DEFAULT nextval('tiket_pesans_id_seq') NOT NULL,
    "tiket_id" bigint NOT NULL,
    "user_id" bigint,
    "nama_pengirim" character varying(255),
    "pesan" text NOT NULL,
    "lampiran" character varying(255),
    "is_admin" boolean DEFAULT false NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "tiket_pesans_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "tikets";
DROP SEQUENCE IF EXISTS tikets_id_seq;
CREATE SEQUENCE tikets_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tikets" (
    "id" bigint DEFAULT nextval('tikets_id_seq') NOT NULL,
    "no_tiket" character varying(255) NOT NULL,
    "judul" character varying(255) NOT NULL,
    "user_id" bigint NOT NULL,
    "email" character varying(255),
    "kategori" character varying(255) DEFAULT 'Umum' NOT NULL,
    "prioritas" character varying(255) DEFAULT 'sedang' NOT NULL,
    "status" character varying(255) DEFAULT 'terbuka' NOT NULL,
    "pesan_awal" text NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "category_id" bigint,
    CONSTRAINT "tikets_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "tikets_prioritas_check" CHECK ((prioritas)::text = ANY ((ARRAY['rendah'::character varying, 'sedang'::character varying, 'tinggi'::character varying])::text[])),
    CONSTRAINT "tikets_status_check" CHECK ((status)::text = ANY ((ARRAY['terbuka'::character varying, 'proses'::character varying, 'selesai'::character varying, 'ditutup'::character varying])::text[]))
)
WITH (oids = false);

CREATE UNIQUE INDEX tikets_no_tiket_unique ON public.tikets USING btree (no_tiket);

INSERT INTO "tikets" ("id", "no_tiket", "judul", "user_id", "email", "kategori", "prioritas", "status", "pesan_awal", "created_at", "updated_at", "category_id") VALUES
(1,	'TKT-2B49CE',	'masalah install',	1,	'admin@imakecustom.com',	'Umum',	'sedang',	'terbuka',	'ada masalah',	'2026-01-26 13:57:38',	'2026-01-26 13:57:38',	5);

DROP TABLE IF EXISTS "tugas";
DROP SEQUENCE IF EXISTS tugas_id_seq;
CREATE SEQUENCE tugas_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tugas" (
    "id" bigint DEFAULT nextval('tugas_id_seq') NOT NULL,
    "queue" character varying(255) NOT NULL,
    "payload" text NOT NULL,
    "attempts" smallint NOT NULL,
    "reserved_at" integer,
    "available_at" integer NOT NULL,
    "created_at" integer NOT NULL,
    CONSTRAINT "tugas_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE INDEX tugas_queue_index ON public.tugas USING btree (queue);


DROP TABLE IF EXISTS "tugas_gagal";
DROP SEQUENCE IF EXISTS tugas_gagal_id_seq;
CREATE SEQUENCE tugas_gagal_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."tugas_gagal" (
    "id" bigint DEFAULT nextval('tugas_gagal_id_seq') NOT NULL,
    "uuid" character varying(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "tugas_gagal_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);

CREATE UNIQUE INDEX tugas_gagal_uuid_unique ON public.tugas_gagal USING btree (uuid);


DROP TABLE IF EXISTS "video";
DROP SEQUENCE IF EXISTS video_id_seq;
CREATE SEQUENCE video_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."video" (
    "id" bigint DEFAULT nextval('video_id_seq') NOT NULL,
    "judul" character varying(255) NOT NULL,
    "url" character varying(255) NOT NULL,
    "keterangan" text,
    "aktif" boolean DEFAULT true NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "unggulan" boolean DEFAULT false NOT NULL,
    "slug" character varying(255),
    CONSTRAINT "video_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


ALTER TABLE ONLY "public"."artikel" ADD CONSTRAINT "artikel_penulis_id_foreign" FOREIGN KEY (penulis_id) REFERENCES pengguna(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."berita" ADD CONSTRAINT "berita_penulis_id_foreign" FOREIGN KEY (penulis_id) REFERENCES pengguna(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."berita_memiliki_kategori" ADD CONSTRAINT "berita_memiliki_kategori_berita_id_foreign" FOREIGN KEY (berita_id) REFERENCES berita(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."berita_memiliki_kategori" ADD CONSTRAINT "berita_memiliki_kategori_kategori_id_foreign" FOREIGN KEY (kategori_id) REFERENCES kategori_berita(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."berita_memiliki_tag" ADD CONSTRAINT "berita_memiliki_tag_berita_id_foreign" FOREIGN KEY (berita_id) REFERENCES berita(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."berita_memiliki_tag" ADD CONSTRAINT "berita_memiliki_tag_tag_id_foreign" FOREIGN KEY (tag_id) REFERENCES tag_berita(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."chat_messages" ADD CONSTRAINT "chat_messages_session_id_foreign" FOREIGN KEY (session_id) REFERENCES chat_sessions(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."chat_sessions" ADD CONSTRAINT "chat_sessions_tiket_id_foreign" FOREIGN KEY (tiket_id) REFERENCES tikets(id) ON DELETE SET NULL NOT DEFERRABLE;
ALTER TABLE ONLY "public"."chat_sessions" ADD CONSTRAINT "chat_sessions_widget_id_foreign" FOREIGN KEY (widget_id) REFERENCES chat_widgets(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."kb_articles" ADD CONSTRAINT "kb_articles_category_id_foreign" FOREIGN KEY (category_id) REFERENCES kb_categories(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."kb_categories" ADD CONSTRAINT "kb_categories_parent_id_foreign" FOREIGN KEY (parent_id) REFERENCES kb_categories(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."komentar" ADD CONSTRAINT "komentar_user_id_foreign" FOREIGN KEY (user_id) REFERENCES pengguna(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."menus" ADD CONSTRAINT "menus_parent_id_foreign" FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."pengguna_peran" ADD CONSTRAINT "pengguna_peran_pengguna_id_foreign" FOREIGN KEY (pengguna_id) REFERENCES pengguna(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."pengguna_peran" ADD CONSTRAINT "pengguna_peran_peran_id_foreign" FOREIGN KEY (peran_id) REFERENCES peran(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."peran_izin" ADD CONSTRAINT "peran_izin_izin_id_foreign" FOREIGN KEY (izin_id) REFERENCES izin(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."peran_izin" ADD CONSTRAINT "peran_izin_peran_id_foreign" FOREIGN KEY (peran_id) REFERENCES peran(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."task_activities" ADD CONSTRAINT "task_activities_task_id_foreign" FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."task_activities" ADD CONSTRAINT "task_activities_user_id_foreign" FOREIGN KEY (user_id) REFERENCES pengguna(id) NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_assigned_to_foreign" FOREIGN KEY (assigned_to) REFERENCES pengguna(id) ON DELETE SET NULL NOT DEFERRABLE;
ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_created_by_foreign" FOREIGN KEY (created_by) REFERENCES pengguna(id) ON DELETE SET NULL NOT DEFERRABLE;
ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_parent_task_id_foreign" FOREIGN KEY (parent_task_id) REFERENCES tasks(id) ON DELETE SET NULL NOT DEFERRABLE;
ALTER TABLE ONLY "public"."tasks" ADD CONSTRAINT "tasks_tiket_id_foreign" FOREIGN KEY (tiket_id) REFERENCES tikets(id) ON DELETE SET NULL NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tiket_categories" ADD CONSTRAINT "tiket_categories_parent_id_foreign" FOREIGN KEY (parent_id) REFERENCES tiket_categories(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tiket_pesans" ADD CONSTRAINT "tiket_pesans_tiket_id_foreign" FOREIGN KEY (tiket_id) REFERENCES tikets(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."tikets" ADD CONSTRAINT "tikets_category_id_foreign" FOREIGN KEY (category_id) REFERENCES tiket_categories(id) ON DELETE SET NULL NOT DEFERRABLE;

-- 2026-07-01 08:15:14 UTC
