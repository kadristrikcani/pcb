import { startStimulusApp } from '@symfony/stimulus-bridge';
import "aos";
// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

window.bootstrap = require('./js/bootstrap.min');
window.Fancybox = Fancybox;
global.$ = global.jQuery = $;