import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Dissemination Toolkit",
  description: "Census and survey data dissemination tool",
  base: "/dissemination-toolkit",
  ignoreDeadLinks: [
    /^https?:\/\/localhost/
  ],

  locales: {
    root: {
      label: 'English',
      lang: 'en',
      themeConfig: {
        nav: [
          { text: 'Home', link: '/' },
          { text: 'Users', link: '/user/introduction' },
          { text: 'Managers', link: '/manager/introduction' },
        ],

        sidebar: {
          '/user/': [
            { text: 'Introduction', link: '/user/introduction' },
            { text: 'Data explorer', link: '/user/data-explorer' },
            { text: 'Visualizations', link: '/user/visualizations' },
            { text: 'Data Stories', link: '/user/data-stories' },
            { text: 'Documents', link: '/user/documents' },
            { text: 'Datasets', link: '/user/datasets' },
            { text: 'REST API', link: '/user/api-reference' },
          ],

          '/manager/': [
            { text: 'Introduction', link: '/manager/introduction' },
            {
              text: 'Access Control',
              collapsed: true,
              items: [
                { text: 'Users', link: '/manager/access-control/users' },
                { text: 'Roles', link: '/manager/access-control/roles' },
              ]
            },
            {
              text: 'Core Configuration',
              collapsed: true,
              items: [
                { text: 'Area Hierarchy', link: '/manager/core-configuration/area-hierarchy' },
                { text: 'Areas', link: '/manager/core-configuration/areas' },
              ]
            },
            {
              text: 'Data',
              collapsed: true,
              items: [
                { text: 'Topics', link: '/manager/data/topics' },
                { text: 'Indicators', link: '/manager/data/indicators' },
                { text: 'Dimensions', link: '/manager/data/dimensions' },
                { text: 'Datasets', link: '/manager/data/datasets' },
                { text: 'Tidy Data Maker', link: '/manager/data/tidy-data-maker' },
                { text: 'Tags', link: '/manager/data/tags' },
              ]
            },
            {
              text: 'Visual Content',
              collapsed: true,
              items: [
                { text: 'Visualizations', link: '/manager/visual-content/visualizations' },
                { text: 'Data Stories', link: '/manager/visual-content/data-stories' },
              ]
            },
            { text: 'Documents', link: '/manager/documents' },
            { text: 'Announcements', link: '/manager/announcements' },
            { text: 'Settings', link: '/manager/settings' },
            { text: 'REST API', link: '/user/api-reference' },
          ],
        },
      }
    },

    fr: {
      label: 'Français',
      lang: 'fr',
      themeConfig: {
        nav: [
          { text: 'Accueil', link: '/fr/' },
          { text: 'Utilisateurs', link: '/fr/user/introduction' },
          { text: 'Gestionnaires', link: '/fr/manager/introduction' },
        ],

        sidebar: {
          '/fr/user/': [
            { text: 'Introduction', link: '/fr/user/introduction' },
            { text: 'Explorateur de données', link: '/fr/user/data-explorer' },
            { text: 'Visualisations', link: '/fr/user/visualizations' },
            { text: 'Récits de données', link: '/fr/user/data-stories' },
            { text: 'Documents', link: '/fr/user/documents' },
            { text: 'Jeux de données', link: '/fr/user/datasets' },
            { text: 'API REST', link: '/fr/user/api-reference' },
          ],

          '/fr/manager/': [
            { text: 'Introduction', link: '/fr/manager/introduction' },
            {
              text: 'Contrôle d\'accès',
              collapsed: true,
              items: [
                { text: 'Utilisateurs', link: '/fr/manager/access-control/users' },
                { text: 'Rôles', link: '/fr/manager/access-control/roles' },
              ]
            },
            {
              text: 'Configuration principale',
              collapsed: true,
              items: [
                { text: 'Hiérarchie des zones', link: '/fr/manager/core-configuration/area-hierarchy' },
                { text: 'Zones', link: '/fr/manager/core-configuration/areas' },
              ]
            },
            {
              text: 'Données',
              collapsed: true,
              items: [
                { text: 'Thèmes', link: '/fr/manager/data/topics' },
                { text: 'Indicateurs', link: '/fr/manager/data/indicators' },
                { text: 'Dimensions', link: '/fr/manager/data/dimensions' },
                { text: 'Jeux de données', link: '/fr/manager/data/datasets' },
                { text: 'Outil de mise en forme de données', link: '/fr/manager/data/tidy-data-maker' },
                { text: 'Étiquettes', link: '/fr/manager/data/tags' },
              ]
            },
            {
              text: 'Contenu visuel',
              collapsed: true,
              items: [
                { text: 'Visualisations', link: '/fr/manager/visual-content/visualizations' },
                { text: 'Récits de données', link: '/fr/manager/visual-content/data-stories' },
              ]
            },
            { text: 'Documents', link: '/fr/manager/documents' },
            { text: 'Annonces', link: '/fr/manager/announcements' },
            { text: 'Paramètres', link: '/fr/manager/settings' },
            { text: 'API REST', link: '/fr/user/api-reference' },
          ],
        },
      }
    }
  },

  themeConfig: {
    search: {
      provider: 'local'
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/tech-acs/dissemination-toolkit' }
    ]
  }
})
