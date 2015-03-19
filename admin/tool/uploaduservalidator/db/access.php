<?php
/**
 * EMEE client block statistics.
 *
 * @package    block_emee
 * @copyright  2013 onwards Pragodata Consulting  {@link http://pdcon.eu}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'tool/uploaduservalidator:use' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),
    ),

);
