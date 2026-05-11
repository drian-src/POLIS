var USANTAuth = (function () {
    'use strict';

    function getUsers() {
        return JSON.parse(localStorage.getItem('usant_users') || '[]');
    }

    function saveUsers(users) {
        localStorage.setItem('usant_users', JSON.stringify(users));
    }

    function getCurrentUser() {
        return JSON.parse(localStorage.getItem('usant_current_user') || 'null');
    }

    function setCurrentUser(user) {
        var session = {
            id: user.id,
            fullName: user.fullName,
            email: user.email,
            role: user.role,
            college: user.college || '',
            yearLevel: user.yearLevel || '',
            organization: user.organization || '',
            office: user.office || '',
            createdAt: user.createdAt
        };
        localStorage.setItem('usant_current_user', JSON.stringify(session));
    }

    function isAuthenticated() {
        return getCurrentUser() !== null;
    }

    function register(data) {
        var users = getUsers();

        for (var i = 0; i < users.length; i++) {
            if (users[i].email === data.email) {
                return { success: false, error: 'An account with this email already exists.' };
            }
        }

        if (!data.fullName || !data.email || !data.password || !data.role) {
            return { success: false, error: 'Please fill in all required fields.' };
        }

        var user = {
            id: 'usr_' + Date.now() + '_' + Math.random().toString(36).substring(2, 8),
            fullName: data.fullName,
            email: data.email,
            password: data.password,
            role: data.role,
            createdAt: new Date().toISOString()
        };

        if (data.role === 'student') {
            user.college = data.college || '';
            user.yearLevel = data.yearLevel || '';
            user.organization = data.organization || '';
        } else if (data.role === 'official') {
            user.office = data.office || '';
        }

        users.push(user);
        saveUsers(users);

        setCurrentUser(user);

        return { success: true, user: user };
    }

    function login(email, password) {
        if (!email || !password) {
            return { success: false, error: 'Please enter your email and password.' };
        }

        var users = getUsers();

        for (var i = 0; i < users.length; i++) {
            if (users[i].email === email && users[i].password === password) {
                setCurrentUser(users[i]);
                return { success: true, user: users[i] };
            }
        }

        for (var j = 0; j < users.length; j++) {
            if (users[j].email === email) {
                return { success: false, error: 'Invalid password. Please try again.' };
            }
        }

        return { success: false, error: 'No account found with this email address.' };
    }

    function logout() {
        localStorage.removeItem('usant_current_user');
    }

    function getDashboardUrl() {
        return '/dashboard';
    }

    function protectRoute() {
        if (!isAuthenticated()) {
            window.location.href = '/';
            return false;
        }
        return true;
    }

    function redirectIfAuthenticated() {
        if (isAuthenticated()) {
            window.location.href = getDashboardUrl();
            return true;
        }
        return false;
    }

    return {
        getUsers: getUsers,
        getCurrentUser: getCurrentUser,
        isAuthenticated: isAuthenticated,
        register: register,
        login: login,
        logout: logout,
        getDashboardUrl: getDashboardUrl,
        protectRoute: protectRoute,
        redirectIfAuthenticated: redirectIfAuthenticated
    };
})();
