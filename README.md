# AmanneX Backend (Headless WordPress CMS)

The headless WordPress backend and content management system powering the **AmanneX Portfolio Website**. Built to deliver portfolio projects, blog posts, taxonomies, and media to the frontend via the WordPress REST API.

---

## 🚀 Overview

- **CMS Architecture**: Headless WordPress
- **Active Theme**: `amannex` (`wp-content/themes/amannex`)
- **API Protocol**: WordPress REST API (v2)
- **Primary Content Types**: Portfolio Projects (`project`), Blog Posts (`post`), Custom Taxonomies & Metadata

---

## 📁 Repository Structure

```text
amannex-backend/
├── wp-content/
│   ├── plugins/                         # Custom plugins (3rd-party ignored)
│   │   └── index.php
│   └── themes/
│       └── amannex/
│           ├── inc/
│           │   └── cpt-projects.php     # Custom Post Type, Taxonomies & Meta Boxes
│           ├── functions.php            # Theme setup & REST API extensions
│           ├── style.css                # Theme metadata
│           └── screenshot.png
├── wp-admin/                            # WordPress Core (ignored in Git)
├── wp-includes/                         # WordPress Core (ignored in Git)
├── .gitignore                           # Git ignore rules for core, secrets, uploads & 3rd-party plugins
└── README.md
```

---

## 🛠️ Features & Customizations

### 1. Custom Post Type: Projects (`project`)
- **Menu**: Accessible directly under **Projects** in the WordPress admin sidebar.
- **Capabilities**: Supports titles, rich text / block editor (case studies), cover images (featured images), excerpts, revisions, and custom fields.
- **Archive & Slug**: `/projects/` and `/projects/{slug}/`.

### 2. Taxonomies
- **Project Categories** (`project_category`): Hierarchical categories (e.g. *Full-Stack*, *Web Development*, *Mobile Apps*, *UI/UX*).
- **Technologies** (`project_tech`): Tag-based tech stack (e.g. *Next.js*, *React*, *TypeScript*, *Docker*, *Tailwind CSS*).

### 3. Project Meta Fields & Admin Panel
Dedicated editor meta box for managing portfolio metadata:
| Field Name | Key | Description |
|---|---|---|
| Live Demo URL | `project_url` | Deployed site or live preview link |
| GitHub URL | `github_url` | Source code repository URL |
| Client / Company | `client_name` | Organization or client name |
| Role | `project_role` | Developer / Designer role |
| Timeline | `project_year` | Completion year or timeframe |
| Featured Project | `featured_project` | Toggle to feature on portfolio homepage |

### 4. Plugins Policy
- **Custom-Made Plugins**: Allowed and tracked in Git. Place your custom plugins inside `wp-content/plugins/` (e.g. `wp-content/plugins/amannex-helper/`).
- **3rd-Party Plugins**: **DO NOT** commit 3rd-party plugins from WordPress.org (e.g. Yoast, WooCommerce, WPGraphQL). They are ignored by `.gitignore` to prevent repository bloat and diff conflicts. Install them through the WordPress Admin dashboard or WP-CLI, and list any dependencies in this README.

---

## 🌐 REST API Endpoints

All endpoints support standard WordPress query parameters (`?per_page=`, `?page=`, `?slug=`, `?order=`, etc.).

### Projects
- **List Projects**: `GET /wp-json/wp/v2/projects`
- **Single Project**: `GET /wp-json/wp/v2/projects/{id}`
- **Filter by Slug**: `GET /wp-json/wp/v2/projects?slug={slug}`
- **Filter Featured**: `GET /wp-json/wp/v2/projects?meta_key=featured_project&meta_value=1`

### Taxonomies
- **Project Categories**: `GET /wp-json/wp/v2/project_categories`
- **Technologies**: `GET /wp-json/wp/v2/project_technologies`

### Posts & Media
- **Blog Posts**: `GET /wp-json/wp/v2/posts`
- **Media Assets**: `GET /wp-json/wp/v2/media`

### ⚡ Optimized REST Fields
To reduce API round-trips for the frontend, the following fields are directly pre-populated in each project response:
- `featured_image_url`: Full resolution URL of the post/project cover image.
- `project_categories_data`: Array of assigned categories with `id`, `name`, and `slug`.
- `project_technologies_data`: Array of assigned technologies with `id`, `name`, and `slug`.

---

## ⚙️ Local Development Setup

This backend runs with Docker Compose alongside the database and frontend.

### 1. Environment Configuration
Ensure your root environment file (`.env`) has your database credentials configured:

```env
MYSQL_DATABASE=wordpress
MYSQL_USER=wordpress_user
MYSQL_PASSWORD=your_secure_password
MYSQL_ROOT_PASSWORD=your_root_password
WORDPRESS_DB_PASSWORD=your_secure_password
```

### 2. Start Services
From the parent project directory:

```bash
docker compose up -d
```

### 3. Flush Permalinks (First Run)
After setting up or pulling updates:
1. Navigate to **WordPress Admin** > **Settings** > **Permalinks**.
2. Select **Post name** (`/%postname%/`).
3. Click **Save Changes** to flush the rewrite rules for the `/projects/` custom post type.

---

## 🔒 Security Best Practices

- `wp-config.php` and `.env` contain sensitive secrets and are ignored by `.gitignore`.
- Media uploads in `wp-content/uploads/` are excluded from Git to prevent repository bloat.
- Keep WordPress core and security salt keys updated.
