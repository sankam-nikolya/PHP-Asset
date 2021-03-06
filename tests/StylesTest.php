<?php
/**
 * PHP library for handling styles and scripts: Add, minify, unify and print.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2017 (c) Josantonius - PHP-Assets
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Asset
 * @since     1.1.5
 */
namespace Josantonius\Asset;

use PHPUnit\Framework\TestCase;

/**
 * Tests class for Asset library.
 *
 * @since 1.1.5
 */
final class StylesTest extends TestCase
{
    /**
     * Asset instance.
     *
     * @since 1.1.6
     *
     * @var object
     */
    protected $Asset;

    /**
     * Assets url.
     *
     * @since 1.1.5
     *
     * @var string
     */
    protected $assetsUrl;

    /**
     * Set up.
     *
     * @since 1.1.5
     */
    public function setUp()
    {
        parent::setUp();

        $this->Asset = new Asset;

        $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        $this->assetsUrl = 'https://' . $url;
    }

    /**
     * Check if it is an instance of Asset.
     *
     * @since 1.1.6
     */
    public function testIsInstanceOfAsset()
    {
        $actual = $this->Asset;

        $this->assertInstanceOf('\Josantonius\Asset\Asset', $actual);
    }

    /**
     * Add style.
     *
     * @since 1.1.5
     */
    public function testAddStyle()
    {
        $this->assertTrue(
            $this->Asset->add('style', [
                'name' => 'style-first',
                'url' => $this->assetsUrl . 'css/style.css',
            ])
        );
    }

    /**
     * Add style with version.
     *
     * @since 1.1.5
     */
    public function testAddStyleWithVersion()
    {
        $this->assertTrue(
            $this->Asset->add('style', [
                'name' => 'style-second',
                'url' => $this->assetsUrl . 'css/style.css',
                'version' => '1.0.0'
            ])
        );
    }

    /**
     * Add style by adding all options.
     *
     * @since 1.1.5
     */
    public function testAddStyleAddingAllParams()
    {
        $this->assertTrue(
            $this->Asset->add('style', [
                'name' => 'style-third',
                'url' => $this->assetsUrl . 'css/custom.css',
                'version' => '1.1.3'
            ])
        );
    }

    /**
     * Add style without specifying a name. [FALSE|ERROR]
     *
     * @since 1.1.5
     */
    public function testAddStyleWithoutName()
    {
        $this->assertFalse(
            $this->Asset->add('style', [
                'url' => $this->assetsUrl . 'css/unknown.css',
                'attr' => 'defer',
            ])
        );
    }

    /**
     * Add style without specifying a url. [FALSE|ERROR]
     *
     * @since 1.1.5
     */
    public function testAddStyleWithoutUrl()
    {
        $this->assertFalse(
            $this->Asset->add('style', [
                'name' => 'unknown',
                'attr' => 'defer',
            ])
        );
    }

    /**
     * Check if the styles have been added correctly.
     *
     * @since 1.1.5
     */
    public function testIfStylesAddedCorrectly()
    {
        $this->assertTrue(
            $this->Asset->isAdded('style', 'style-first')
        );

        $this->assertTrue(
            $this->Asset->isAdded('style', 'style-second')
        );

        $this->assertTrue(
            $this->Asset->isAdded('style', 'style-third')
        );
    }

    /**
     * Delete added styles.
     *
     * @since 1.1.5
     */
    public function testRemoveAddedStyles()
    {
        $this->assertTrue(
            $this->Asset->remove('style', 'style-first')
        );
    }

    /**
     * Validation after deletion.
     *
     * @since 1.1.5
     */
    public function testValidationAfterDeletion()
    {
        $this->assertFalse(
            $this->Asset->isAdded('style', 'style-first')
        );
    }

    /**
     * Output styles.
     *
     * @since 1.1.5
     */
    public function testOutputStyles()
    {
        $styles = $this->Asset->outputStyles();

        $this->assertContains(
            "<link rel='stylesheet' href='https://jst.com/css/custom.css'>",
            $styles
        );

        $this->assertContains(
            "<link rel='stylesheet' href='https://jst.com/css/style.css'>",
            $styles
        );
    }

    /**
     * Output when there are not header styles loaded.
     *
     * @since 1.1.5
     */
    public function testOutputWhenNotStylesLoaded()
    {
        $this->assertFalse(
            $this->Asset->outputStyles()
        );
    }
}
