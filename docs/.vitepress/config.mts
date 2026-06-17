import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Dissemination Toolkit",
  description: "Census and survey data dissemination tool",
  base: "/dissemination-toolkit",
  ignoreDeadLinks: [
    /^https?:\/\/localhost/
  ],

  themeConfig: {
    search: {
      provider: 'local'
    },

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
            { text: 'Data stories', link: '/manager/visual-content/data-stories' },
          ]
        },
        { text: 'Documents', link: '/manager/documents' },
        { text: 'Announcements', link: '/manager/announcements' },
        { text: 'Settings', link: '/manager/settings' },
      ],
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/tech-acs/dissemination-toolkit' }
    ]
  }
})