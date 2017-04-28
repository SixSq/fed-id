<?php

$config = array(

    // This is a authentication source which handles admin authentication.
    'admin' => array(
        // The default is to use core:AdminPassword, but it can be replaced with
        // any authentication source.

        'core:AdminPassword',
    ),


    // An authentication source which can authenticate against both SAML 2.0
    // and Shibboleth 1.3 IdPs.
    'sixsq-saml-bridge' => array(
        'saml:SP',

        // The entity ID of this SP.
        // Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
        'entityID' => null,

        // The entity ID of the IdP this should SP should contact.
        // Can be NULL/unset, in which case the user will be shown a list of available IdPs.
        'idp' => null,

        // The URL to the discovery service.
        // Can be NULL/unset, in which case a builtin discovery service will be used.
        'discoURL' => getenv('FP_BASEURL') . '/samlbridge/module.php/discopower/disco.php',

        'privatekey' => 'server.pem',
        'certificate' => 'server.crt',

        'redirect.sign' => true,
        'redirect.validate' => true,
        'sign.authnrequest' => true,
        'sign.logout' => true,
        'validate.logout' => true,

        'attributes' => array(
            'eduPersonUniqueID' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.13',
            'eduPersonTargetedID' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.10',
            'eduPersonPrincipalName' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
            'displayName' => 'urn:oid:2.16.840.1.113730.3.1.241',
            'cn' => 'urn:oid:2.5.4.3',
            'mail' => 'urn:oid:0.9.2342.19200300.100.1.3',
            'eduPersonAffiliation' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.1',
            'eduPersonScopedAffiliation' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.9',
            'schacHomeOrganization' => 'urn:oid:1.3.6.1.4.1.25178.1.2.9',
            'schacHomeOrganizationType' => 'urn:oid:1.3.6.1.4.1.25178.1.2.10',
        ),

        'attributes.required' => array(
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.13',        // eduPersonUniqueID
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.10',        // eduPersonTargetedID
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',         // eduPersonPrincipalName
            'urn:oid:2.16.840.1.113730.3.1.241',        // displayName
            'urn:oid:2.5.4.3',                          // cn commonName
            'urn:oid:0.9.2342.19200300.100.1.3',        // mail
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.1',         // eduPersonAffiliation
            'urn:oid:1.3.6.1.4.1.5923.1.1.1.9',         // eduPersonScopedAffiliation
            'urn:oid:1.3.6.1.4.1.25178.1.2.9',          // schacHomeOrganization
            'urn:oid:1.3.6.1.4.1.25178.1.2.10',         // schacHomeOrganizationType
        ),

        'EntityAttributes' => array(
            'http://macedir.org/entity-category' => array(
                'http://www.geant.net/uri/dataprotection-code-of-conduct/v1',
            ),
        ),

        /* 'RegistrationInfo' => array(
            'authority' => '',
            'instant' => '',
            'policies' => array(
                'en' => '',
                'de' => ''
            )
        ), */

        'UIInfo' => array(
            'DisplayName' => array(
                'en' => 'SixSq Federated Identity Portal'
            ),
            'Description' => array(
                'en' => 'The SixSq Federated Identity Portal provides support for basic authentication and authorization through external identity providers and federations'
            ),
            'Logo' => array(
                array(
                    'url' => 'http://sixsq.com/img/content/logo_sixsq.png',
                    'height' => 150
                )
            ),
            'PrivacyStatementURL' => array(
                'en' => 'http://sixsq.com/'
            )
        ),

        'name' => array(
            'en' => 'SixSq Federated Identity Portal'
        ),

        'description' => array(
          'en' => 'The SixSq Federated Identity Portal provides support for basic authentication and authorization through external identity providers and federations'
        ),

        'contacts' => array(
            array(
                'contactType' => 'administrative',
                'emailAddress' => 'info@sixsq.com ',
                'givenName' => '',
                'surName' => ''
            ),
            array(
                'contactType' => 'support',
                'emailAddress' => 'support@sixsq.com',
                'givenName' => '',
                'surName' => ''
            )
        ),

        'OrganizationName' => array(
            'en' => 'SixSq'
        ),

        'OrganizationDisplayName' => array(
            'en' => 'SixSq'
        ),

        'OrganizationURL' => array(
            'en' => 'http://sixsq.com/'
        ),

        /*
         * WARNING: SHA-1 is disallowed starting January the 1st, 2014.
         *
         * Uncomment the following option to start using SHA-256 for your signatures.
         * Currently, simpleSAMLphp defaults to SHA-1, which has been deprecated since
         * 2011, and will be disallowed by NIST as of 2014. Please refer to the following
         * document for more information:
         *
         * http://csrc.nist.gov/publications/nistpubs/800-131A/sp800-131A.pdf
         *
         * If you are uncertain about identity providers supporting SHA-256 or other
         * algorithms of the SHA-2 family, you can configure it individually in the
         * IdP-remote metadata set for those that support it. Once you are certain that
         * all your configured IdPs support SHA-2, you can safely remove the configuration
         * options in the IdP-remote metadata set and uncomment the following option.
         *
         * Please refer to the hosted SP configuration reference for more information.
          */
        'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',

    ),

);
