<h2>Overview</h2>

<p>Loops is a powerful section for controlling the native WordPress loop and WP Query. With layout controls.</p>

[![Introduction to the Loops Section](http://img.youtube.com/vi/OjHN9qHtG_E/0.jpg)](http://www.youtube.com/watch?v=OjHN9qHtG_E)

<h2>Installation & Activation</h2>

<p>Loops can easily be downloaded from inside WordPress using <a href="http://www.pagelines.com/resources/extend/">Extend</a>.</p>

<ol>
<li>Download the plugin from <a href="http://www.pagelines.com/resources/extend/">Extend</a>. It will now appear in your <strong>Plugins</strong> tab.</li>
<li>Click <strong>Plugins</strong>, and find your Loops plugin (titled <strong>PageLines Section Loops</strong>).</li>
<li>Click <strong>Activate</strong> to be able to use the plugin inside your editor.</li>
<li>Go to your PageLines Builder where you will now find Loops in the <strong>Content</strong> section.</li>
</ol>

<h2>Settings</h2>

<p>As with all section, the Loops section includes the <a href="http://www.pagelines.com/resources/standard-section-options/">Standard Section Options</a> such as padding/margin, background options and etc.</p>

<p>The Loops section options are separated into three categories, these are Layout options, Query options and Meta Query options.</p>

<h3>Layout Options</h3>

<p>The Layout options provide control over the look of posts in the Loops section.</p>

<p><strong>Loops Shortcodes / HTML</strong><br />
All post elements such as title, featured image and so forth are controlled using shortcodes. Use these shortcodes to control the dynamic post info. The shortcodes can be ordered in any way you like, creating a unique post layout rathe than the traditional title, image, content etc...</p>

<p>Clicking the <strong>Reference</strong> button will expand the shortcode list, showing all available shortcodes.</p>

<pre><code class="language-markup">
[loops_title align="left"]
[loops_media size="thumbnail" align="left"]
[loops_content]
[loops_comments]
[loops_excerpt length="80"]
[loops_author]
[loops_date format="F j, Y"]
[loops_link text="Read More" align="left"]
[loops_avatar size="64" align="left"]
</code></pre>

<p>You can change the alignment using <code>align=""</code> with either <code>left</code>, <code>center</code> or <code>right</code>. The media shortcode supports thumbnail and all <a href="https://codex.wordpress.org/Post_Formats" target="_blank">post format</a> elements.</p>

<p>For further customization, you can also include a <code>class=""</code> attribute to each shortcode. This allows you to add your own styling to each shortcode.</p>

<pre><code class="language-markup">
[loops_title align="left" class="my-custom-class"]
</code></pre>

<p><strong>Grid Columns Standard</strong><br />
Allows you to control how your posts are displayed such as in a grid or listed like a traditional blog. You can select between four columns, three columns, two columns and one column. One column is the default option and lists your posts like a traditional blog.</p>

<p><strong>Grid Columns On Mobile</strong><br />
The Grid Columns On Mobile options operates the same as the Grid Columns Standard option, but will only affect mobile devices. This is useful if you wish to use a different layout option on mobile devices.</p>

<p><strong>Base Font Size (px)</strong><br />
Provides control over the font size for the Loops section, you can select between 10 pixels and 32 pixels. The value you select will affect all type in the Loops section.</p>

<h3>Query Options</h3>

<p>The Query options provide control over what content is displayed in the Loops section.</p>

<p><strong>Select Post Type</strong><br />
This provides control over what post type populates the Loops section. Out-the-box, this option will have the Pages post type and the Posts post type. However, if you create any custom post types they too will be listed for you to use.</p>

<p><strong>Select Taxonomy Term</strong><br />
This allows you to filter the content for the post type you select in the <strong>Select Post Type</strong> option. For example, if you select the Posts post type, you will be able to display posts from a specific category or tag.</p>

<p>This is useful if you wish to use Loops on a category or tag archive page or create a magazine layout.</p>

<p><strong>Sort Elements by Postdate</strong><br />
This provides control over how your posts are sorted, you can select between:</p>

<ul>
<li>Date Descending (Default)</li>
<li>Date Ascending</li>
<li>Random</li>
</ul>

<p><strong>Posts Per Page (adds pagination)</strong><br />
Provides control over how many posts are displayed in the Loops section, you can select between 0-32 posts. This option will also add pagination to the bottom of the Loops section for paged navigation.</p>

<p><strong>Posts Offset</strong><br />
This allows you to skip posts from the value you have selected. This is useful if you're creating a magazine layout or using a post slider that is already displaying your latest posts.</p>

<h3>Meta Query Options</h3>

<p>The Meta Query options are for advanced users and allows you to populate the Loops section with posts using specific query options. This is useful if you wish to display featured products from WooCommerce or products within a certain price range.</p>

<p>For more information on the WP Query, please review the <a href="https://codex.wordpress.org/Class_Reference/WP_Query#Custom_Field_Parameters" target="_blank">WP_Query Documentation</a> on the WordPress Codex.</p>

<h2>Shortcode</h2>

<p>The Loops section can be inserted into a page, post or widget using the shortcode below. This is used as a quick reference and we recommend including a unique ID.</p>

<pre><code class="language-markup">
[[pl_section section="loops" id="Enter_Unique_Id_Here"]]
</code></pre>

<h2>Classes</h2>

<p>We recommend using your own custom classes via the <a href="http://www.pagelines.com/resources/additional-section-classes/">Additional Styling Classes</a> option to customize sections. However, you can use the classes below as a quick reference or in your own styles, if you prefer to use the default class(es) instead of your own.</p>

```css
/* pl-sn-loops class is assigned to the &lt;section&gt; element */
.pl-sn-loops { ... }

/* loops-wrap class is assigned to the div that wraps all posts */
.loops-wrap { ... }

/* Assigned to the &lt;article&gt; element */
.loops-post { ... }

/* Post elements */
.pl-loops-excerpt { ... }
.pl-loops-content { ... }
.pl-loops-author { ... }
.pl-loops-thumb { ... }
.pl-loops-title { ... }
.pl-loops-date { ... }
.pl-loops-link { ... }

/* Pagination */
.pl-pagination-simple { ... }
.page-numbers .current { ... }
.page-numbers .next { ... }
.page-numbers .prev { ... }
.page-numbers { ... }
```

= 5.0.20 =

* Added 6 columns option.
