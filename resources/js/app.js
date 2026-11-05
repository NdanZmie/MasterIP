import './bootstrap';
import gsap from 'gsap';

// Expose GSAP globally for page transitions and dashboard animations
window.gsap = gsap;

// Mount React Login App only when #login-root exists (Code-splitting: prevents login CSS & 800kB bundle from loading on Dashboard)
const loginRootEl = document.getElementById('login-root');
if (loginRootEl) {
    Promise.all([
        import('react'),
        import('react-dom/client'),
        import('./components/LoginApp')
    ]).then(([React, { createRoot }, { default: LoginApp }]) => {
        const props = loginRootEl.dataset.props ? JSON.parse(loginRootEl.dataset.props) : {};
        const root = createRoot(loginRootEl);
        root.render(React.createElement(LoginApp, props));
    });
}
