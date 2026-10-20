<?php
/**
 * Register Custom Post Type: Projects
 * For AmanneX Portfolio Website (Headless & REST API ready)
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register Projects Custom Post Type & Taxonomies
 */
function amannex_register_projects_cpt() {
    // 1. Project Post Type Labels
    $labels = [
        'name'                  => _x('Projects', 'Post Type General Name', 'amannex'),
        'singular_name'         => _x('Project', 'Post Type Singular Name', 'amannex'),
        'menu_name'             => __('Projects', 'amannex'),
        'name_admin_bar'        => __('Project', 'amannex'),
        'archives'              => __('Project Archives', 'amannex'),
        'attributes'            => __('Project Attributes', 'amannex'),
        'parent_item_colon'     => __('Parent Project:', 'amannex'),
        'all_items'             => __('All Projects', 'amannex'),
        'add_new_item'          => __('Add New Project', 'amannex'),
        'add_new'               => __('Add New', 'amannex'),
        'new_item'              => __('New Project', 'amannex'),
        'edit_item'             => __('Edit Project', 'amannex'),
        'update_item'           => __('Update Project', 'amannex'),
        'view_item'             => __('View Project', 'amannex'),
        'view_items'            => __('View Projects', 'amannex'),
        'search_items'          => __('Search Projects', 'amannex'),
        'not_found'             => __('No projects found', 'amannex'),
        'not_found_in_trash'    => __('No projects found in Trash', 'amannex'),
        'featured_image'        => __('Project Cover Image', 'amannex'),
        'set_featured_image'    => __('Set project cover image', 'amannex'),
        'remove_featured_image' => __('Remove cover image', 'amannex'),
        'use_featured_image'    => __('Use as cover image', 'amannex'),
        'insert_into_item'      => __('Insert into project', 'amannex'),
        'uploaded_to_this_item' => __('Uploaded to this project', 'amannex'),
        'items_list'            => __('Projects list', 'amannex'),
        'items_list_navigation' => __('Projects list navigation', 'amannex'),
        'filter_items_list'     => __('Filter projects list', 'amannex'),
    ];

    $args = [
        'label'                 => __('Project', 'amannex'),
        'description'           => __('Portfolio project showcase', 'amannex'),
        'labels'                => $labels,
        'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'],
        'taxonomies'            => ['project_category', 'project_tech'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Essential for Gutenberg Block Editor and Headless REST API
        'rest_base'             => 'projects',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'               => [
            'slug'       => 'projects',
            'with_front' => false,
        ],
    ];

    register_post_type('project', $args);

    // 2. Project Categories Taxonomy (e.g. Web Dev, Mobile App, UI/UX)
    $cat_labels = [
        'name'              => _x('Project Categories', 'taxonomy general name', 'amannex'),
        'singular_name'     => _x('Project Category', 'taxonomy singular name', 'amannex'),
        'search_items'      => __('Search Project Categories', 'amannex'),
        'all_items'         => __('All Project Categories', 'amannex'),
        'parent_item'       => __('Parent Category', 'amannex'),
        'parent_item_colon' => __('Parent Category:', 'amannex'),
        'edit_item'         => __('Edit Category', 'amannex'),
        'update_item'       => __('Update Category', 'amannex'),
        'add_new_item'      => __('Add New Category', 'amannex'),
        'new_item_name'     => __('New Category Name', 'amannex'),
        'menu_name'         => __('Categories', 'amannex'),
    ];

    register_taxonomy('project_category', ['project'], [
        'hierarchical'      => true,
        'labels'            => $cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rest_base'         => 'project_categories',
        'rewrite'           => ['slug' => 'project-category', 'with_front' => false],
    ]);

    // 3. Project Technologies / Tags Taxonomy (e.g. Next.js, React, Docker, Tailwind)
    $tech_labels = [
        'name'                       => _x('Technologies', 'taxonomy general name', 'amannex'),
        'singular_name'              => _x('Technology', 'taxonomy singular name', 'amannex'),
        'search_items'               => __('Search Technologies', 'amannex'),
        'popular_items'              => __('Popular Technologies', 'amannex'),
        'all_items'                  => __('All Technologies', 'amannex'),
        'edit_item'                  => __('Edit Technology', 'amannex'),
        'update_item'                => __('Update Technology', 'amannex'),
        'add_new_item'               => __('Add New Technology', 'amannex'),
        'new_item_name'              => __('New Technology Name', 'amannex'),
        'separate_items_with_commas' => __('Separate technologies with commas', 'amannex'),
        'add_or_remove_items'        => __('Add or remove technologies', 'amannex'),
        'choose_from_most_used'      => __('Choose from most used technologies', 'amannex'),
        'not_found'                  => __('No technologies found.', 'amannex'),
        'menu_name'                  => __('Technologies', 'amannex'),
    ];

    register_taxonomy('project_tech', ['project'], [
        'hierarchical'          => false,
        'labels'                => $tech_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'show_in_rest'          => true,
        'rest_base'             => 'project_technologies',
        'rewrite'               => ['slug' => 'technology', 'with_front' => false],
    ]);
}
add_action('init', 'amannex_register_projects_cpt', 0);

/**
 * Register Project Meta Fields for WP REST API and Block Editor
 */
function amannex_register_project_meta() {
    $meta_fields = [
        'project_url' => [
            'type'              => 'string',
            'description'       => 'Live project demo or site URL',
            'sanitize_callback' => 'esc_url_raw',
        ],
        'github_url' => [
            'type'              => 'string',
            'description'       => 'Source code repository URL',
            'sanitize_callback' => 'esc_url_raw',
        ],
        'client_name' => [
            'type'              => 'string',
            'description'       => 'Client or company name',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        'project_role' => [
            'type'              => 'string',
            'description'       => 'Role on the project (e.g. Lead Developer, Full-Stack)',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        'project_year' => [
            'type'              => 'string',
            'description'       => 'Year or duration of the project (e.g. 2024 - 2025)',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        'featured_project' => [
            'type'              => 'boolean',
            'description'       => 'Whether this project is highlighted on the portfolio homepage',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ],
    ];

    foreach ($meta_fields as $field => $config) {
        register_post_meta('project', $field, [
            'show_in_rest'      => true,
            'single'            => true,
            'type'              => $config['type'],
            'description'       => $config['description'],
            'sanitize_callback' => $config['sanitize_callback'],
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }
}
add_action('init', 'amannex_register_project_meta');

/**
 * Add Admin Meta Box for Easy Editing in WordPress Dashboard
 */
function amannex_add_project_meta_boxes() {
    add_meta_box(
        'amannex_project_details',
        __('Project Links & Details', 'amannex'),
        'amannex_render_project_meta_box',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'amannex_add_project_meta_boxes');

/**
 * Render Project Meta Box in WordPress Admin
 */
function amannex_render_project_meta_box($post) {
    wp_nonce_field('amannex_save_project_meta', 'amannex_project_meta_nonce');

    $project_url      = get_post_meta($post->ID, 'project_url', true);
    $github_url       = get_post_meta($post->ID, 'github_url', true);
    $client_name      = get_post_meta($post->ID, 'client_name', true);
    $project_role     = get_post_meta($post->ID, 'project_role', true);
    $project_year     = get_post_meta($post->ID, 'project_year', true);
    $featured_project = get_post_meta($post->ID, 'featured_project', true);
    ?>
    <style>
        .amannex-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 24px;
            margin-top: 10px;
        }
        .amannex-field {
            display: flex;
            flex-direction: column;
        }
        .amannex-field.full-width {
            grid-column: span 2;
        }
        .amannex-field label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #1e1e1e;
        }
        .amannex-field input[type="text"],
        .amannex-field input[type="url"] {
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }
        .amannex-field .description {
            font-size: 12px;
            color: #646970;
            margin-top: 4px;
        }
        .amannex-checkbox-field {
            grid-column: span 2;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-top: 1px solid #f0f0f1;
            margin-top: 8px;
        }
        .amannex-checkbox-field label {
            font-weight: 600;
            cursor: pointer;
        }
    </style>

    <div class="amannex-meta-grid">
        <div class="amannex-field">
            <label for="project_url"><?php _e('Live Demo URL', 'amannex'); ?></label>
            <input type="url" id="project_url" name="project_url" value="<?php echo esc_url($project_url); ?>" placeholder="https://example.com" />
            <span class="description"><?php _e('Public link to view the deployed project.', 'amannex'); ?></span>
        </div>

        <div class="amannex-field">
            <label for="github_url"><?php _e('GitHub / Repository URL', 'amannex'); ?></label>
            <input type="url" id="github_url" name="github_url" value="<?php echo esc_url($github_url); ?>" placeholder="https://github.com/user/project" />
            <span class="description"><?php _e('Source code link for this project.', 'amannex'); ?></span>
        </div>

        <div class="amannex-field">
            <label for="client_name"><?php _e('Client / Company', 'amannex'); ?></label>
            <input type="text" id="client_name" name="client_name" value="<?php echo esc_attr($client_name); ?>" placeholder="e.g. Acme Corp or Personal" />
            <span class="description"><?php _e('Organization or client the project was built for.', 'amannex'); ?></span>
        </div>

        <div class="amannex-field">
            <label for="project_role"><?php _e('Your Role', 'amannex'); ?></label>
            <input type="text" id="project_role" name="project_role" value="<?php echo esc_attr($project_role); ?>" placeholder="e.g. Full-Stack Developer, UI Designer" />
            <span class="description"><?php _e('Your key responsibilities or title.', 'amannex'); ?></span>
        </div>

        <div class="amannex-field full-width">
            <label for="project_year"><?php _e('Timeline / Year', 'amannex'); ?></label>
            <input type="text" id="project_year" name="project_year" value="<?php echo esc_attr($project_year); ?>" placeholder="e.g. 2024 - 2025" />
            <span class="description"><?php _e('Completion year or timeframe.', 'amannex'); ?></span>
        </div>

        <div class="amannex-checkbox-field">
            <input type="checkbox" id="featured_project" name="featured_project" value="1" <?php checked($featured_project, '1'); ?> />
            <label for="featured_project"><?php _e('Mark as Featured Project (highlight on portfolio home page)', 'amannex'); ?></label>
        </div>
    </div>
    <?php
}

/**
 * Save Project Meta Box Data
 */
function amannex_save_project_meta_box($post_id) {
    if (!isset($_POST['amannex_project_meta_nonce']) || !wp_verify_nonce($_POST['amannex_project_meta_nonce'], 'amannex_save_project_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $text_fields = ['client_name', 'project_role', 'project_year'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }

    $url_fields = ['project_url', 'github_url'];
    foreach ($url_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, esc_url_raw($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }

    $featured = !empty($_POST['featured_project']) ? '1' : '0';
    update_post_meta($post_id, 'featured_project', $featured);
}
add_action('save_post_project', 'amannex_save_project_meta_box');

/**
 * Add Category and Technology names/objects directly in Project REST payload
 * to save extra API queries on the frontend.
 */
function amannex_add_project_rest_fields() {
    register_rest_field('project', 'project_categories_data', [
        'get_callback' => function ($post_arr) {
            $terms = get_the_terms($post_arr['id'], 'project_category');
            if (empty($terms) || is_wp_error($terms)) {
                return [];
            }
            return array_map(function ($term) {
                return [
                    'id'   => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $terms);
        },
        'schema' => null,
    ]);

    register_rest_field('project', 'project_technologies_data', [
        'get_callback' => function ($post_arr) {
            $terms = get_the_terms($post_arr['id'], 'project_tech');
            if (empty($terms) || is_wp_error($terms)) {
                return [];
            }
            return array_map(function ($term) {
                return [
                    'id'   => $term->term_id,
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $terms);
        },
        'schema' => null,
    ]);
}
add_action('rest_api_init', 'amannex_add_project_rest_fields');
