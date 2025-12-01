# OOP #
<h2> Objektově Orientované Programování <br/>   
(Object-Oriented Programming) </h2>

1. Objekty
2. Abstrakce
3. Zapouzdření
4. Kompozice 
5. Dědičnost
6. Polymorfismus - v PHP jsou metody ve třídach automaticky virtuální


### Polymorfismus v PHP ###
<pre style="white-space: pre; overflow-x: auto;"><code>
class Animal {
    public function expressYourself() {
        echo 'I am a animal';
    }
}

class Dog extends Animal {
    public function expressYourself() {
        echo 'woof-woof!';
    }
}

class Cat extends Animal {
    public function expressYourself() {
        echo 'meow-meow!'';
    }
}

$animals = [];
$animals[] = new Dog();
$animals[] = new Cat()

foreach ($animals as $animal) {
    echo $animal->expressYourself().", ";
}
// Output: woof-woof!, meow-meow!
</code></pre>

### Polymorfismus v C# ###

<pre style="white-space: pre; overflow-x: auto;"><code>
namespace ConsoleApp1
{
    internal class Animal
    {
        public virtual void expressYourself()
        {
            Console.Write("I am a animal");
        }
    }
    
    internal class Dog : Animal
    {
        public override void expressYourself()
        {
            Console.Write("woof-woof");
        }
    }
    
    internal class Cat : Animal
    {
        public override void expressYourself()
        {
            Console.Write("meow-meow");
        }
    }
    
    
    internal class Program
    {
        static void Main(string[] args)
        {
            List&lt;Animal&gt; animals = new List&lt;Animal&gt;();
            animals.Add(new Dog());
            animals.Add(new Cat());

            foreach (var animal in animals)
            {
                animal.expressYourself();
                Console.Write(", ");
            }
        }
    }
}

// Output: woof-woof, meow-meow
</code></pre>