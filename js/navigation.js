/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 * Also handles search functionality.
 */
( function() {
    const body = document.body;
    const siteNavigation = document.getElementById( 'site-navigation' );

    // Return early if the navigation doesn't exist.
    if ( ! siteNavigation ) {
        return;
    }

    const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

    // Return early if the button doesn't exist.
    if ( 'undefined' === typeof button ) {
        return;
    }

    const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof menu ) {
        button.style.display = 'none';
        return;
    }

    if ( ! menu.classList.contains( 'nav-menu' ) ) {
        menu.classList.add( 'nav-menu' );
    }

    // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
    button.addEventListener( 'click', function() {
        siteNavigation.classList.toggle( 'toggled' );
        body.classList.toggle( 'no-scroll' );

        if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
            button.setAttribute( 'aria-expanded', 'false' );
        } else {
            button.setAttribute( 'aria-expanded', 'true' );
        }
    } );

    // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
    document.addEventListener( 'click', function( event ) {
        const isClickInside = siteNavigation.contains( event.target );

        if ( ! isClickInside ) {
            siteNavigation.classList.remove( 'toggled' );
            body.classList.remove( 'no-scroll' );
            button.setAttribute( 'aria-expanded', 'false' );
        }
    } );

    // Get all the link elements within the menu.
    const links = menu.getElementsByTagName( 'a' );

    // Get all the link elements with children within the menu.
    const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

    // Toggle focus each time a menu link is focused or blurred.
    for ( const link of links ) {
        link.addEventListener( 'focus', toggleFocus, true );
        link.addEventListener( 'blur', toggleFocus, true );
    }

    // Toggle focus each time a menu link with children receive a touch event.
    for ( const link of linksWithChildren ) {
        link.addEventListener( 'touchstart', toggleFocus, false );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
        if ( event.type === 'focus' || event.type === 'blur' ) {
            let self = this;
            // Move up through the ancestors of the current link until we hit .nav-menu.
            while ( ! self.classList.contains( 'nav-menu' ) ) {
                // On li elements toggle the class .focus.
                if ( 'li' === self.tagName.toLowerCase() ) {
                    self.classList.toggle( 'focus' );
                }
                self = self.parentNode;
            }
        }

        if ( event.type === 'touchstart' ) {
            const menuItem = this.parentNode;
            event.preventDefault();
            for ( const link of menuItem.parentNode.children ) {
                if ( menuItem !== link ) {
                    link.classList.remove( 'focus' );
                }
            }
            menuItem.classList.toggle( 'focus' );
        }
    }

    // 検索機能の追加
    const searchToggle = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');

    // 検索関連の要素が存在する場合のみ処理を実行
    if (searchToggle && searchOverlay && searchClose) {
        // 検索オーバーレイを開く
        searchToggle.addEventListener('click', function () {
            searchOverlay.classList.add('active');
            // 検索フィールドが存在する場合のみフォーカスを設定
            const searchField = document.querySelector('.search-field');
            if (searchField) {
                searchField.focus();
            }
            document.body.style.overflow = 'hidden';
            body.classList.add('no-scroll');
        });

        // 検索オーバーレイを閉じる
        searchClose.addEventListener('click', function () {
            searchOverlay.classList.remove('active');
            document.body.style.overflow = '';
            body.classList.remove('no-scroll');
        });

        // ESCキーで検索オーバーレイを閉じる
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                document.body.style.overflow = '';
                body.classList.remove('no-scroll');
            }
        });
    }
}() );