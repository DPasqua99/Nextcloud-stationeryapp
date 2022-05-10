import { generateFilePath } from '@nextcloud/router'

import Vue from 'vue'
import App from './App'

// Correct the root of the app for chunk loading
// linkTo matches the apps folders
// generateUrl ensure the index.php (or not)
// We do not want the index.php since we're loading files
// eslint-disable-next-line
if (!process.env.HOT) {
	// eslint-disable-next-line
	__webpack_public_path__ = generateFilePath(appName, '', 'js/')
}

Vue.mixin({ methods: { t, n } })

export default new Vue({
	el: '#content',
	render: h => h(App),
})
