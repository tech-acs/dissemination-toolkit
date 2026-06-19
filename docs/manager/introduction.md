# Introduction

The management dashboard is where authorised users create, manage, and publish content on the Dissemination Toolkit. Access is controlled through a role-based permission system.

## Logging in

Click the **Login** button in the top-right corner of the public site. After signing in with your credentials, you are redirected to the management dashboard at `/manage/home`.

## Permissions model

The toolkit uses granular permissions. Each action (create, edit, delete, publish) on each content type (topics, indicators, dimensions, datasets, stories, visualizations, documents) is controlled by a specific permission. Users are assigned to **roles**, and roles are granted permissions.

A **Super Admin** role bypasses all permission checks and has access to everything, including user management, role configuration, area management, and organization settings.

## Dashboard overview

The management home page presents a grid of cards, each linking to a management section:

- **Manage visualizations** — create, customize, and share interactive data visualizations
- **Manage stories** — build data-driven narratives using the story designer
- **Manage topics** — organize indicators, visualizations, and stories into semantic categories
- **Manage indicators** — create, update, and assign indicators to topics
- **Manage dimensions** — define descriptive attributes used to slice and dice data
- **Manage datasets** — import and manage collections of tabular data
- **Manage documents** — upload census tables with Dublin Core metadata

## Navigation

The top navigation bar provides quick links to each content section. The **admin wrench icon** (visible only to Super Admin users) opens a dropdown with advanced configuration options:

- **Access Control** — Users and Roles
- **Core Configuration** — Area Hierarchy and Areas
- **Dissemination** — Organisation settings and Tags
- **Announcements**
