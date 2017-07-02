module Types where

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type Name = String

newtype ProjectName = ProjectName { getProjectName :: String } deriving (Show, Eq, Ord)
newtype FunctorName = FunctorName { getFunctorName :: String } deriving (Show, Eq, Ord)
newtype AlgebraName = AlgebraName { getAlgebraName :: String } deriving (Show, Eq, Ord)
newtype ClassName   = ClassName   { getClassName   :: String } deriving (Show, Eq, Ord)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type FunctorDef     = Either FunctorSubset2 ClassInjection

type FunctorSubset  = (FunctorName, ProjectName, [PropertySubset]) -- not used anymore?
type PropertySubset  = (ClassName, [Name])

type ClassInjection = (AlgebraName, FunctorName, [MethodInjection])
type MethodInjection = (ClassName, [Name], [Statement])

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type FunctorSubset2  = (FunctorName, ProjectName, [PropertySubset2])
type PropertySubset2  = (ClassName, [(Name, Maybe KeyorderName)])

data KeyorderName
    = KeyorderName String
    | KeyorderList KeyorderName
    | KeyorderTuple [KeyorderName]
    | KeyorderWildcard

type Properties2 = [(Name, PropertyType, Maybe KeyorderName)]

type ClassSpec2 = (ClassName, Properties2)

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
type ClassSpec = (ClassName, Properties)

type Properties = [(Name, PropertyType, Maybe Expression)]

data PropertyType
    = IntType
    | FloatType
    | StringType
    | BoolType
    | ListType     PropertyType
    | ObjectType   [ClassName]
    | MapType Name ClassName
    | TupleType    [PropertyType]
    | AbstractType Name -- used only during parsing, will not be part of Properties

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
data ClassDef = ClassDef ClassName (Maybe ClassName) Properties StaticProperties ([Name], [Statement]) [Method]

classDefClassName :: ClassDef -> ClassName
classDefClassName (ClassDef cn _ _ _ _ _) = cn

type StaticProperties = [(Name, Expression)]

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
data Method
    = Method       ClassName Name [Name] [(Name, Expression)] [Statement]
    | StaticMethod ClassName Name [Name] [(Name, Expression)] [Statement]
                                                    -- JS                           PHP
data Statement
    = Define Name Expression                        -- var name = <E> ;             $name = <E> ;
    | Assign Expression Expression                  -- foo.x['w'] = <E> ;           $foo->x['w'] = <E> ;
    | IfS Expression [Statement] [Statement]        -- if(e1){..} else {..}         if(e1){..} else {..}
    | Return Expression                             -- return <E> ;                 return <E> ;
    | Expr Expression
    | For0To Name Name [Statement]

data Expression
    = NULL                                          -- null                         null
    | S String                                      -- "string"                     "string"
    | I Int                                         -- 123                          123
    | B Bool                                        --
    | F Float                                       --
    | NAME Name                                      -- name                         $name
    | CNAME ClassName                                     -- Name                         Name
    | ASSOC [(Name, Expression)]                    -- {}                           array()
    | ISASSOC Expression                            -- isObject(<E>)                is_array(<E>)   ???
    | KEY Expression Name                           -- <E> ['name']                 <E> ['name']
    | HASKEY Name Expression                        -- (name in e)                  isset(e['name'])
    | ARRAY [Expression]                         -- [e1, e2, e3]
    | AT Expression Expression                     -- e1[e2]
    | NEW ClassName [Expression]                    -- new ClassName (e1, ..)       new ClassName (e1, ..)
    | PROP Expression Name                          -- <E> .name                    <E> ->name
    | SPROP Expression Name                         -- <E> .name                    <E>::$name
    | STATIC ClassName Name                         -- A.foo                        array(A, 'foo')
    | STATICE Expression Name                         -- A.foo                        array(A, 'foo')
    | METHOD Expression Name                        -- <E>.foo                      array(<E>, 'foo')
    | CALL Expression [Expression]                   -- e(e1,..eN)                   call_user_func(e, e1, .. eN)
    | PRIM String [Expression]                       -- e(e1,..eN)                   call_user_func(e, e1, .. eN)
    | FUNC Name                                     -- foo                          'foo'
    | LAMBDA [Name] [Statement] [Name]              -- function(x,y){s1;..sN}       function(x1,..,xN){s1;..sN}use(v1,..vN)
    | IF Expression Expression Expression          -- e1 ? e2 : e3                 e1 ? e2 : e3
    | Expression :==  Expression                     -- e1 == e2                     e1 == e2
    | Expression :=== Expression                     -- e1 == e2                     e1 == e2
    | Expression :/== Expression                     -- e1 == e2                     e1 == e2
    | Expression :/=  Expression                     -- e1 == e2                     e1 == e2
    | Expression :||  Expression                     -- e1 == e2                     e1 == e2
    | Expression :++  Expression                     -- e1 + e2                      e1 + e2
    | Expression :+:  Expression                     -- e1 + e2                      e1 + e2
    | Expression :-:  Expression                     -- e1 + e2                      e1 + e2
    | Expression :*:  Expression                     -- e1 + e2                      e1 + e2
    | Expression :/:  Expression                     -- e1 + e2                      e1 + e2
    | Expression :%:  Expression                     -- e1 + e2                      e1 + e2

-------------------------------------------------------------------------------
--
-------------------------------------------------------------------------------
