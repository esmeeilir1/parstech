/**
 * Person Show Page JavaScript
 * این فایل شامل تمام عملکردهای مربوط به صفحه نمایش اطلاعات شخص است
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeComponents();

    // Add event listeners
    setupEventListeners();

    // Add animations
    setupAnimations();
});

/**
 * Initialize all necessary components
 */
function initializeComponents() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize all accordions
    const accordionElements = document.querySelectorAll('.accordion');
    accordionElements.forEach(accordion => {
        new bootstrap.Collapse(accordion, {
            toggle: false
        });
    });
}

/**
 * Setup all event listeners
 */
function setupEventListeners() {
    // Add hover effects to accordion items
    const accordionItems = document.querySelectorAll('.accordion-item');
    accordionItems.forEach(item => {
        item.addEventListener('mouseenter', handleAccordionHover);
        item.addEventListener('mouseleave', handleAccordionLeave);
    });

    // Add click handlers for accordion buttons
    const accordionButtons = document.querySelectorAll('.accordion-button');
    accordionButtons.forEach(button => {
        button.addEventListener('click', handleAccordionClick);
    });

    // Setup bank account interactions
    setupBankAccountHandlers();

    // Setup copy functionality
    setupCopyFunctionality();
}

/**
 * Setup animations for elements
 */
function setupAnimations() {
    // Add animation to list items
    const listItems = document.querySelectorAll('.list-group-item');
    listItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 50}ms`;
        item.classList.add('fade-in');
    });

    // Add animation to accordion items
    const accordionItems = document.querySelectorAll('.accordion-item');
    accordionItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 100}ms`;
        item.classList.add('slide-in');
    });
}

/**
 * Handle accordion item hover
 * @param {Event} event
 */
function handleAccordionHover(event) {
    this.classList.add('hover-shadow');
}

/**
 * Handle accordion item leave
 * @param {Event} event
 */
function handleAccordionLeave(event) {
    this.classList.remove('hover-shadow');
}

/**
 * Handle accordion button click
 * @param {Event} event
 */
function handleAccordionClick(event) {
    const content = this.nextElementSibling;
    if (content) {
        content.style.transition = 'all 0.3s ease-in-out';
    }
}

/**
 * Setup bank account related functionality
 */
function setupBankAccountHandlers() {
    const bankAccounts = document.querySelectorAll('.bank-account');
    bankAccounts.forEach(account => {
        account.addEventListener('click', function(event) {
            // Only toggle if not clicking on a copyable element
            if (!event.target.closest('[data-copyable]')) {
                this.classList.toggle('expanded');
            }
        });
    });
}

/**
 * Setup copy functionality for important information
 */
function setupCopyFunctionality() {
    const copyableElements = document.querySelectorAll('[data-copyable]');

    copyableElements.forEach(element => {
        element.addEventListener('click', async function(event) {
            event.preventDefault();
            event.stopPropagation();

            const textToCopy = this.getAttribute('data-copyable');

            try {
                await navigator.clipboard.writeText(textToCopy);
                showCopySuccess(this);
            } catch (err) {
                showCopyError(this);
            }
        });
    });
}

/**
 * Show copy success message
 * @param {HTMLElement} element
 */
function showCopySuccess(element) {
    const originalContent = element.innerHTML;
    element.innerHTML = '<i class="bi bi-check2"></i> کپی شد';
    element.classList.add('copy-success');

    setTimeout(() => {
        element.innerHTML = originalContent;
        element.classList.remove('copy-success');
    }, 2000);
}

/**
 * Show copy error message
 * @param {HTMLElement} element
 */
function showCopyError(element) {
    const originalContent = element.innerHTML;
    element.innerHTML = '<i class="bi bi-x"></i> خطا در کپی';
    element.classList.add('copy-error');

    setTimeout(() => {
        element.innerHTML = originalContent;
        element.classList.remove('copy-error');
    }, 2000);
}

/**
 * Add loading state to an element
 * @param {HTMLElement} element
 */
function addLoadingState(element) {
    element.classList.add('loading');
    element.setAttribute('disabled', 'disabled');
}

/**
 * Remove loading state from an element
 * @param {HTMLElement} element
 */
function removeLoadingState(element) {
    element.classList.remove('loading');
    element.removeAttribute('disabled');
}

/**
 * Format numbers with commas
 * @param {number} number
 * @returns {string}
 */
function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/**
 * Format currency amounts
 * @param {number} amount
 * @returns {string}
 */
function formatCurrency(amount) {
    return formatNumber(amount) + ' ریال';
}

/**
 * Check if element is in viewport
 * @param {HTMLElement} element
 * @returns {boolean}
 */
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

/**
 * Handle scroll animations
 */
function handleScrollAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');

    elements.forEach(element => {
        if (isInViewport(element)) {
            element.classList.add('animated');
        }
    });
}

// Add scroll event listener for animations
window.addEventListener('scroll', handleScrollAnimations);
