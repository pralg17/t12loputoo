namespace HelmesBootcamp.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class DeleteGarage : DbMigration
    {
        public override void Up()
        {
            AddColumn("dbo.Garages", "Deleted", c => c.DateTime());
        }
        
        public override void Down()
        {
            DropColumn("dbo.Garages", "Deleted");
        }
    }
}
