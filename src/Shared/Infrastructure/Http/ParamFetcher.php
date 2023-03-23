<?php

    namespace App\Shared\Infrastructure\Http;

    use App\Shared\Domain\Exception\InvalidInputDataException;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Class ParamFetcher
     * @package App\Shared\Infrastructure\Http
     */
    final class ParamFetcher
    {

        /**
         * @var array<string, mixed>
         */
        private array $data;

        /**
         * @param array<string, mixed> $data
         */
        public function __construct(array $data)
        {
            $this->data = $data;
        }

        /**
         * @param Request $request
         *
         * @return static
         */
        public static function fromRequestBody(Request $request): self
        {
            return new self($request->request->all());
        }

        /**
         * @param Request $request
         *
         * @return static
         */
        public static function fromRequestQuery(Request $request): self
        {
            return new self($request->query->all());
        }

        /**
         * @param string $key
         *
         * @return string
         */
        public function getRequiredString(string $key): string
        {
            $this->assertRequired($key);
            return (string) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return string|null
         */
        public function getNullableString(string $key): ?string
        {
            if (!isset($this->data[$key])) {
                return null;
            }
            return (string) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return float
         */
        public function getRequiredFloat(string $key): float
        {
            $this->assertRequired($key);
            return (float) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return float|null
         */
        public function getNullableFloat(string $key): ?float
        {
            if (!isset($this->data[$key])) {
                return null;
            }
            return (float) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return int
         */
        public function getRequiredInt(string $key): int
        {
            $this->assertRequired($key);
            return (int) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return int|null
         */
        public function getNullableInt(string $key): ?int
        {
            if (!isset($this->data[$key])) {
                return null;
            }
            return (int) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return array
         */
        public function getRequiredArray(string $key): array
        {
            $this->assertRequired($key);
            return (array) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return array|null
         */
        public function getNullableArray(string $key): ?array
        {
            if (!isset($this->data[$key])) {
                return null;
            }
            return (array) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function getRequiredBool(string $key): bool
        {
            $this->assertRequired($key);
            return (bool) $this->data[$key];
        }

        /**
         * @param string $key
         *
         * @return bool|null
         */
        public function getNullableBool(string $key): ?bool
        {
            if (!isset($this->data[$key])) {
                return null;
            }
            return (bool) $this->data[$key];
        }

        /**
         * @todo get bool
         */

        /**
         * @param string $key
         */
        private function assertRequired(string $key): void
        {
            self::keyExists($this->data, $key, sprintf('%s not found', $key));
            self::notNull($this->data[$key], sprintf('%s should be not null', $key));
        }

        /**
         * @param $array
         * @param $key
         * @param string $message
         */
        public static function keyExists($array, $key, string $message = '')
        {
            if (!(isset($array[$key]) || \array_key_exists($key, $array))) {
                static::reportInvalidArgument(
                    \sprintf(
                        $message ?: 'Expected the key %s to exist.',
                        self::valueToString($key)
                    )
                );
            }
        }

        /**
         * @param $value
         * @param string $message
         */
        public static function notNull($value, string $message = '')
        {
            if (null === $value) {
                static::reportInvalidArgument(
                    $message ?: 'Expected a value other than null.'
                );
            }
        }

        /**
         * @param $message
         *
         * @throws InvalidInputDataException
         */
        protected static function reportInvalidArgument($message)
        {
            throw new InvalidInputDataException($message);
        }

        /**
         * @param mixed $value
         *
         * @return string
         */
        protected static function valueToString($value)
        {
            if (null === $value) {
                return 'null';
            }

            if (true === $value) {
                return 'true';
            }

            if (false === $value) {
                return 'false';
            }

            if (\is_array($value)) {
                return 'array';
            }

            if (\is_object($value)) {
                if (\method_exists($value, '__toString')) {
                    return \get_class($value).': '.self::valueToString($value->__toString());
                }

                if ($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
                    return \get_class($value).': '.self::valueToString($value->format('c'));
                }

                return \get_class($value);
            }

            if (\is_resource($value)) {
                return 'resource';
            }

            if (\is_string($value)) {
                return '"'.$value.'"';
            }

            return (string) $value;
        }

        /**
         * @param $key
         *
         * @return bool
         */
        public function hasString($key): bool
        {
            return isset($this->data[$key]) && $this->data[$key] !== null;
        }

        /**
         * @param $key
         *
         * @return bool
         */
        public function hasInt($key): bool
        {
            return isset($this->data[$key]) && (int) $this->data[$key] > 0;
        }

        /**
         * @param $key
         *
         * @return bool
         */
        public function hasArray($key): bool
        {
            return isset($this->data[$key]) && is_array($this->data[$key]);
        }
    }
