<?php

/**
 * This file is part of the StackExchangeApiClient library.
 *
 * @author  benatespina <benatespina@gmail.com>
 *
 * @license MIT
 */

namespace spec\BenatEspina\StackExchangeApiClient;

use BenatEspina\StackExchangeApiClient\Authentication\AuthenticationInterface;
use BenatEspina\StackExchangeApiClient\Authentication\OAuth2;
use BenatEspina\StackExchangeApiClient\Client;
use BenatEspina\StackExchangeApiClient\Method\CommentAPI;
use BenatEspina\StackExchangeApiClient\Model\Error;
use PhpSpec\ObjectBehavior;

/**
 * Class ClientSpec.
 *
 * @package spec\Benatespina\StackExchangeApiClient
 */
class ClientSpec extends ObjectBehavior
{
    const ACCESS_TOKEN = 'ZJiotG5w9O4RxR7NZ*B0EQ))';
    const KEY = 'Suy)bfhQl6vE3YgSwFZPxA((';

    function it_is_initializable()
    {
        $this->shouldHaveType('BenatEspina\StackExchangeApiClient\Client');
    }

    function it_gets_a_request()
    {
        $this->get('/answers', array('site' => 'stackoverflow', 'sort' => 'activity'))->shouldBeArray();
    }

    function it_gets_a_request_with_authentication(AuthenticationInterface $authentication)
    {
        $this->beConstructedWith($authentication);

        $authentication->getAuthAsString()->shouldBeCalled()->willReturn(
            '&access_token=' . self::ACCESS_TOKEN . '&key=' . self::KEY
        );
        $this->get('/me/badges', array('site' => 'stackoverflow', 'sort' => 'rank', 'order' => 'desc'))
            ->shouldBeArray();
    }

    function it_posts_a_request_without_authentication()
    {
        $this->post('/filters/create')->shouldBeArray();
    }

    function it_posts_a_request_with_authentication(AuthenticationInterface $authentication)
    {
        $this->beConstructedWith($authentication);

        $authentication->getAuth()->shouldBeCalled()->willReturn(
            array('access_token' => self::ACCESS_TOKEN, 'key' => self::KEY)
        );
        $this->post(
            '/answers/4914/accept',
            array(),
            array('site' => 'StackApps')
        )->shouldBeArray();

        $authentication->getAuth()->shouldBeCalled()->willReturn(
            array('access_token' => self::ACCESS_TOKEN, 'key' => self::KEY)
        );
        $this->post(
            '/answers/4914/accept/undo',
            array(),
            array('site' => 'StackApps')
        )->shouldBeArray();
    }

    function it_puts_a_request(AuthenticationInterface $authentication)
    {
        $this->beConstructedWith($authentication);

        $authentication->getAuth()->shouldBeCalled()->willReturn(
            array('access_token' => self::ACCESS_TOKEN, 'key' => self::KEY)
        );
        $this->put(
            '/answers/4914/edit',
            array(
                'site'    => 'StackApps',
                'body'    => 'If you have improves about the library, please tell me :)' . mt_rand(),
                'comment' => 'Edit from api request'
            )
        )->shouldBeArray();
    }

    function it_deletes_a_request(AuthenticationInterface $authentication)
    {
        $oauth2 = new OAuth2(self::KEY, self::ACCESS_TOKEN);
        $client = new Client($oauth2);
        $commentApi = new CommentAPI($client);

        $comment = $commentApi->create(
            '4878',
            array(
                'site' => 'StackApps',
                'body' => 'This is a ' . mt_rand() . ' dummy comment from an Api to test the delete request.'
            )
        );


        $this->beConstructedWith($authentication);

        $authentication->getAuth()->shouldBeCalled()->willReturn(
            array('access_token' => self::ACCESS_TOKEN, 'key' => self::KEY)
        );

        $this->delete(
            '/comments/' . $comment->getId() . '/delete',
            array('site' => 'StackApps')
        )->shouldBeArray();
    }

    function it_throws_an_400_bad_parameter_exception()
    {
        $this->shouldThrow(
            new Error(
                array(
                    'error_id'      => 400,
                    'error_message' => 'site is required',
                    'error_name'    => 'bad_parameter'
                )
            )
        )->during('get', array('/answers'));
    }

    function it_throws_a_404_no_method_exception()
    {
        $this->shouldThrow(
            new Error(
                array(
                    'error_id'      => 404,
                    'error_message' => 'no method found with this name',
                    'error_name'    => 'no_method'
                )
            )
        )->during('post', array('/no-method'));
    }
}
