<?php

require_once __DIR__ . '/class-component-testcase.php';

use \Exporter\Components\Audio as Audio;

class Audio_Test extends Component_TestCase {

	public function testGeneratedJSON() {
		$workspace = $this->prophet->prophesize( '\Exporter\Workspace' );
		// get_file_contents and write_tmp_files must be caleld with the specified
		// params
		$workspace->get_file_contents( 'http://someurl.com/audio-file.mp3?some_query=string' )->willReturn( 'foo' )->shouldBeCalled();
		$workspace->write_tmp_file( 'audio-file.mp3', 'foo' )->willReturn( true )->shouldBeCalled();

		// Pass the mock workspace as a dependency
		$component = new Audio( '<audio><source src="http://someurl.com/audio-file.mp3?some_query=string"></audio>',
			$workspace->reveal(), $this->settings, $this->styles, $this->layouts );

		// Test for valid JSON
		$this->assertEquals(
			array( 'role' => 'audio', 'URL' => 'bundle://audio-file.mp3' ),
			$component->to_array()
		);
	}

}
