<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
    'title' => array(
        'type'  => 'text',
        'label' => __( 'Title', 'fw' ),
        'value' => '',
        'desc'  => __( 'Enter slide title', 'fw' )
    ),
    'subtitle' => array(
        'type'  => 'text',
        'label' => __( 'Subtitle', 'fw' ),
        'value' => '',
        'desc'  => __( 'Enter slide subtitle', 'fw' )
    ),

    'type' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'picker' => array(
            'divider_type'  => array(
                'type'  => 'select',
                'value' => '',
                'label' => __('Slide Type', 'fw'),
                'desc'  => __('Select slide type', 'fw'),
                'choices' => array(
                    'default' => __('With simple photo', 'fw'),
                    'caption' => __('With caption effect', 'fw'),
                    'left-cation' => __('Left side effect', 'fw'),
                    'top-caption' => __('Top link text', 'fw')
                ),
            )
        ),
        'choices' => array(
            'caption' => array(
                'text'          => array(
                    'label' => __( 'Text', 'fw' ),
                    'desc'  => __( 'Add caption text', 'fw' ),
                    'type'  => 'textarea',
                    'value' => ''
                ),
            ),
            'left-cation' => array(
                'title'          => array(
                    'label' => __( 'Title', 'fw' ),
                    'desc'  => __( 'Add caption title', 'fw' ),
                    'type'  => 'text',
                    'value' => ''
                ),
                'url'          => array(
                    'label' => __( 'URL', 'fw' ),
                    'desc'  => __( 'Add title URL', 'fw' ),
                    'type'  => 'text',
                    'value' => ''
                ),
                'desc'          => array(
                    'label' => __( 'Description', 'fw' ),
                    'desc'  => __( 'Add caption short description', 'fw' ),
                    'type'  => 'textarea',
                    'value' => ''
                ),
                'button' => array(
                    'type'  => 'multi-picker',
                    'label' => false,
                    'desc'  => false,
                    'picker' => array(
                        'enable-btn' => array(
                            'type'  => 'switch',
                            'value' => 'no',
                            'label' => __('Button', 'fw'),
                            'desc'  => __('Enable caption button', 'fw'),
                            'left-choice' => array(
                                'value' => 'no',
                                'label' => __('No', 'fw'),
                            ),
                            'right-choice' => array(
                                'value' => 'yes',
                                'label' => __('Yes', 'fw'),
                            ),
                        )
                    ),
                    'choices' => array(
                        'yes' => array(
                            'btn_link_group' => array(
                                'type'    => 'group',
                                'options' => array(
                                    'label'          => array(
                                        'label' => __( 'Label', 'fw' ),
                                        'desc'  => __( 'This is the text that appears on your button', 'fw' ),
                                        'type'  => 'text',
                                        'value' => 'Submit'
                                    ),

                                    'link'   => array(
                                        'label' => __( 'Link', 'fw' ),
                                        'desc'  => __( 'Where should your button link to?', 'fw' ),
                                        'type'  => 'text',
                                        'value' => '#'
                                    ),
                                    'target' => array(
                                        'type'         => 'switch',
                                        'label'        => __( '', 'fw' ),
                                        'desc'         => __( 'Open link in new window?', 'fw' ),
                                        'value'        => '_self',
                                        'right-choice' => array(
                                            'value' => '_blank',
                                            'label' => __( 'Yes', 'fw' ),
                                        ),
                                        'left-choice'  => array(
                                            'value' => '_self',
                                            'label' => __( 'No', 'fw' ),
                                        ),
                                    ),

                                    'icon_box' => array(
                                        'type'  => 'multi-picker',
                                        'label' => false,
                                        'desc'  => false,
                                        'picker' => array(
                                            'icon_type'       => array(
                                                'label'   => __( 'Icon', 'fw' ),
                                                'desc'    => __( 'Choose icon type', 'fw' ),
                                                'attr'    => array( 'class' => 'fw-checkbox-float-left' ),
                                                'type'    => 'radio',
                                                'value'   => 'awesome',
                                                'choices' => array(
                                                    'awesome' => __( 'Font Awesome', 'fw' ),
                                                    'custom' => __( 'Custom Icon Class', 'fw' )
                                                )
                                            ),
                                        ),
                                        'choices' => array(
                                            'awesome' => array(
                                                'icon'          => array(
                                                    'type'  => 'icon',
                                                    'label' => __( '', 'fw' ),
                                                    'desc'  => __( 'Choose icon', 'fw' )
                                                ),
                                            ),
                                            'custom' => array(
                                                'icon'          => array(
                                                    'type'  => 'text',
                                                    'label' => __( '', 'fw' ),
                                                    'desc'  => __( 'Add custom icon class', 'fw' )
                                                ),
                                            )
                                        )
                                    ),

                                    'size'       => array(
                                        'label'   => __( 'Size', 'fw' ),
                                        'desc'    => __( 'Choose button size', 'fw' ),
                                        'attr'    => array( 'class' => 'fw-checkbox-float-left' ),
                                        'type'    => 'radio',
                                        'value'   => 'btn-large',
                                        'choices' => array(
                                            'btn-small' => __( 'Small', 'fw' ),
                                            'btn-medium' => __( 'Normal', 'fw' ),
                                            'btn-large' => __( 'Large', 'fw' ),
                                            'btn-xlarge' => __( 'Very Large', 'fw' )
                                        )
                                    ),

                                    'shape'       => array(
                                        'label'   => __( 'Shape', 'fw' ),
                                        'desc'    => __( 'Choose button shape', 'fw' ),
                                        'attr'    => array( 'class' => 'fw-checkbox-float-left' ),
                                        'type'    => 'radio',
                                        'value'   => 'btn-default',
                                        'choices' => array(
                                            'btn-default' => __( 'Default', 'fw' ),
                                            'btn-square' => __( 'Square', 'fw' ),
                                            'btn-round' => __( 'Round', 'fw' )
                                        )
                                    ),


                                    'colors'       => array(
                                        'label'   => __( 'Types', 'fw' ),
                                        'desc'    => __( 'Choose theme default button color and gradient', 'fw' ),
                                        'attr'    => array( 'class' => 'fw-checkbox-float-left' ),
                                        'help'  => __( 'You can add a custom class to add another colors or styles to buttons.', 'fw' ),
                                        'type'    => 'select',
                                        'value'   => '',
                                        'choices' => array(
                                            'btn-default-color' => __( 'Default', 'fw' ),
                                            'btn-green-color' => __( 'Green', 'fw' ),
                                            'btn-dark-color' => __( 'Dark', 'fw' ),
                                            'btn-gradient' => __( 'Gradient', 'fw' ),
                                            'btn-line' => __( 'Without BG Color', 'fw' )
                                        )
                                    ),

                                    'class'          => array(
                                        'label' => __( 'Custom Btn Class', 'fw' ),
                                        'desc'  => __( 'Enter custom button CSS class', 'fw' ),
                                        'help'  => __( 'You can use this class to further style button shortcode by adding your custom CSS.', 'fw' ),
                                        'type'  => 'text',
                                        'value' => '',
                                    ),
                                )
                            )
                        )
                    )
                ),
            ),
            'top-caption' => array(
                'text'          => array(
                    'label' => __( 'Text', 'fw' ),
                    'desc'  => __( 'Add link text', 'fw' ),
                    'type'  => 'text',
                    'value' => ''
                ),
                'url'          => array(
                    'label' => __( 'URL', 'fw' ),
                    'desc'  => __( 'Add slide URL', 'fw' ),
                    'type'  => 'text',
                    'value' => ''
                ),
            )
        )
    ),
);